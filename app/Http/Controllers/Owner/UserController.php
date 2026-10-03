<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * แสดงรายชื่อผู้ใช้
     */
    public function index()
    {

        $users = User::orderBy('created_at', 'desc')
            ->get();

        return view(
            'owner.users',
            compact('users')
        );

    }

    /**
     * เพิ่มผู้ใช้
     */
    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required',

            'username' => 'required|unique:users',

            'password' => 'required|min:6',

            'role' => 'required|in:customer,admin,owner',

        ]);

        User::create([

            'name' => $request->name,

            'username' => $request->username,

            'password' => Hash::make(
                $request->password
            ),

            'role' => $request->role,

        ]);

        return back()->with(
            'success',
            'เพิ่มบัญชีผู้ใช้เรียบร้อยแล้ว'
        );

    }

    /**
     * แก้ไขผู้ใช้
     */
    public function update(Request $request, User $user)
    {
        $request->validate([

            'name' => 'required',

            'username' => 'required|unique:users,username,'.$user->id,

            'role' => 'required|in:customer,admin,owner',

            'password' => 'nullable|min:6',

        ]);

        $user->name = $request->name;

        $user->username = $request->username;

        $user->role = $request->role;

        // ถ้ามีการกรอกรหัสผ่านใหม่
        if ($request->filled('password')) {

            $user->password = Hash::make(
                $request->password
            );

        }

        $user->save();

        return back()->with(
            'success',
            'แก้ไขบัญชีผู้ใช้เรียบร้อยแล้ว'
        );
    }

    /**
     * ลบผู้ใช้
     */
    public function destroy(User $user)
    {

        // ป้องกันลบตัวเอง

        if (auth()->id() === $user->id) {

            return back()->with(
                'error',
                'ไม่สามารถลบบัญชีตัวเองได้'
            );

        }

        $user->delete();

        return back()->with(
            'success',
            'ลบบัญชีเรียบร้อยแล้ว'
        );

    }
}
