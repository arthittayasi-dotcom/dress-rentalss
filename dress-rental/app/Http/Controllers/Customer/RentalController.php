<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Dress;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function index(Request $request): View
    {
        $rentals = Rental::with('dress')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('customers.rentals', compact('rentals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dress_id' => ['required', 'exists:dresses,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ], [
            'dress_id.required' => 'กรุณาเลือกชุด',
            'dress_id.exists' => 'ไม่พบชุดที่เลือก',
            'start_date.required' => 'กรุณาเลือกวันที่เริ่มเช่า',
            'start_date.after_or_equal' => 'วันที่เริ่มเช่าต้องเป็นวันนี้หรือวันถัดไป',
            'end_date.required' => 'กรุณาเลือกวันที่คืน',
            'end_date.after_or_equal' => 'วันที่คืนต้องไม่น้อยกว่าวันที่เริ่มเช่า',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $dress = Dress::whereKey($validated['dress_id'])->lockForUpdate()->firstOrFail();

            if ($dress->status === 'maintenance') {
                return back()
                    ->withInput()
                    ->with('error', 'ชุดนี้ยังไม่พร้อมให้เช่า');
            }

            $hasConflict = Rental::where('dress_id', $dress->id)
                ->whereIn('status', [
                    'pending',
                    'approved',
                    'renting',
                ])
                ->whereDate('start_date', '<=', $validated['end_date'])
                ->whereDate('end_date', '>=', $validated['start_date'])
                ->exists();

            if ($hasConflict) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'ชุดนี้มีรายการจองในช่วงวันที่ที่เลือก กรุณาเลือกวันอื่น'
                    );
            }

            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);

            $rentalDays = max(1, (int) $startDate->diffInDays($endDate));

            $pricePerDay = (float) $dress->price_per_day;
            $totalPrice = $rentalDays * $pricePerDay;

            Rental::create([
                'user_id' => $request->user()->id,
                'dress_id' => $dress->id,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'rental_days' => $rentalDays,
                'price_per_day' => $pricePerDay,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            return redirect()
                ->route('customer.rentals')
                ->with(
                    'success',
                    'ส่งคำขอเช่าเรียบร้อยแล้ว รอ Admin ตรวจสอบ'
                );
        });
    }
}
