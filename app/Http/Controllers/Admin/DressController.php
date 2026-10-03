<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DressController extends Controller
{
    public function index()
    {
        $dresses = Dress::orderByRaw(
            'CAST(SUBSTRING(code, 3) AS UNSIGNED) ASC'
        )->paginate(10);

        return view(
            'admin.dresses.index',
            compact('dresses')
        );
    }

    public function store(Request $request)
    {

        $request->validate([

            'code' => [
                'required',
                'unique:dresses',
            ],

            'name' => [
                'required',
            ],

            'price_per_day' => [
                'required',
                'numeric',
            ],

            'image' => [
                'nullable',
                'image',
                'max:2048',
            ],

        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('dresses', 'public');

        }

        Dress::create([

            'code' => $request->code,

            'name' => $request->name,

            'size' => $request->size,

            'type' => $request->type,

            'price_per_day' => $request->price_per_day,

            'status' => 'available',

            'image' => $imagePath,

            'description' => $request->description,

        ]);

        return back()
            ->with(
                'success',
                'เพิ่มชุดเรียบร้อยแล้ว'
            );

    }

    public function update(Request $request, Dress $dress)
    {

        $request->validate([

            'name' => [
                'required',
            ],

            'price_per_day' => [
                'required',
                'numeric',
            ],

            'image' => [
                'nullable',
                'image',
                'max:2048',
            ],

        ]);

        $imagePath = $dress->image;

        if ($request->hasFile('image')) {

            if ($dress->image) {

                Storage::disk('public')
                    ->delete($dress->image);

            }

            $imagePath = $request
                ->file('image')
                ->store('dresses', 'public');

        }

        $dress->update([

            'name' => $request->name,

            'size' => $request->size,

            'type' => $request->type,

            'price_per_day' => $request->price_per_day,

            'status' => $request->status ?? $dress->status,

            'image' => $imagePath,

            'description' => $request->description,

        ]);

        return back()
            ->with(
                'success',
                'แก้ไขชุดเรียบร้อยแล้ว'
            );

    }

    public function destroy(Dress $dress)
    {

        if ($dress->image) {

            Storage::disk('public')
                ->delete($dress->image);

        }

        $dress->delete();

        return back()
            ->with(
                'success',
                'ลบชุดเรียบร้อยแล้ว'
            );

    }
}
