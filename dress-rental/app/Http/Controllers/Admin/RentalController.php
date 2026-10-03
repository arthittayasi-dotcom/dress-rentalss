<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // รายการเช่าทั้งหมด
    public function index()
    {

        $rentals = Rental::with([
            'dress',
            'user',
        ])
            ->latest()
            ->get();

        return view(
            'admin.rentals.index',
            compact('rentals')
        );

    }

    // อนุมัติคำขอ
    public function approve(Rental $rental)
    {

        $rental->update([

            'status' => 'approved',

            'approved_at' => now(),

        ]);

        if ($rental->dress) {

            $rental->dress->update([

                'status' => 'booked',

            ]);

        }

        return back()->with(
            'success',
            'อนุมัติการเช่าเรียบร้อยแล้ว'
        );

    }

    // ปฏิเสธคำขอ
    public function reject(
        Request $request,
        Rental $rental
    ) {

        $request->validate([

            'rejection_reason' => 'required|string|max:255',

        ]);

        $rental->update([

            'status' => 'rejected',

            'rejection_reason' => $request->rejection_reason,

            'rejected_at' => now(),

        ]);

        return back()->with(
            'success',
            'ปฏิเสธคำขอเรียบร้อยแล้ว'
        );

    }

    // ลูกค้ามารับชุด
    public function startRental(
        Rental $rental
    ) {

        $rental->update([

            'status' => 'renting',

        ]);

        if ($rental->dress) {

            $rental->dress->update([

                'status' => 'rented',

            ]);

        }

        return back()->with(
            'success',
            'เริ่มการเช่าเรียบร้อยแล้ว'
        );

    }

    // รับคืนชุด
    public function returnDress(
        Request $request,
        Rental $rental
    ) {

        $request->validate([

            'return_condition' => 'required|string',

            'return_note' => 'nullable|string',

        ]);

        $rental->update([

            'status' => 'returned',

            'return_condition' => $request->return_condition,

            'return_note' => $request->return_note,

            'returned_at' => now(),

        ]);

        if ($rental->dress) {

            $rental->dress->update([

                'status' => 'available',

            ]);

        }

        return back()->with(
            'success',
            'รับคืนชุดเรียบร้อยแล้ว'
        );

    }

    // ยกเลิกรายการ
    public function cancel(
        Rental $rental
    ) {

        $rental->update([

            'status' => 'cancelled',

        ]);

        if ($rental->dress) {

            $rental->dress->update([

                'status' => 'available',

            ]);

        }

        return back()->with(
            'success',
            'ยกเลิกรายการแล้ว'
        );

    }
}
