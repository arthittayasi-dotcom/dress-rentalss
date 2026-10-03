<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;

class DashboardController extends Controller
{
    public function index()
    {

        // สถานะการเช่า

        $pending = Rental::where('status', 'pending')
            ->count();

        $approved = Rental::where('status', 'approved')
            ->count();

        $renting = Rental::where('status', 'renting')
            ->count();

        $returned = Rental::where('status', 'returned')
            ->count();

        // จำนวนรายการเช่าทั้งหมด
        // ไม่เอารายการที่ถูกปฏิเสธ

        $totalRentals = Rental::where(
            'status',
            '!=',
            'rejected'
        )->count();

        // รายได้รวม
        // ใช้ Logic เดียวกับ Report

        $totalSales = Rental::where(
            'status',
            '!=',
            'rejected'
        )
            ->sum('total_price');

        // รายได้วันนี้

        $todaySales = Rental::where(
            'status',
            '!=',
            'rejected'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->sum('total_price');

        // เช่าล่าสุด

        $latestRental = Rental::with([
            'dress',
            'user',
        ])
            ->latest()
            ->first();

        // รายการที่ต้องคืนวันนี้

        $returnToday = Rental::where(
            'status',
            'renting'
        )
            ->whereDate(
                'end_date',
                today()
            )
            ->count();

        return view(
            'admin.dashboard',
            compact(
                'pending',
                'approved',
                'renting',
                'returned',
                'totalRentals',
                'totalSales',
                'todaySales',
                'latestRental',
                'returnToday'
            )
        );

    }
}
