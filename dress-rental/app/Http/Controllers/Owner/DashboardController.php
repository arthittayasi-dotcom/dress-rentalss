<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Dress;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'start_date' => [
                'nullable',
                'required_with:end_date',
                'date_format:Y-m-d',
            ],
            'end_date' => [
                'nullable',
                'required_with:start_date',
                'date_format:Y-m-d',
                'after_or_equal:start_date',
            ],
        ]);

        $hasDateFilter = !empty($validated['start_date'])
            && !empty($validated['end_date']);

        // หากยังไม่เลือกวันที่ ให้กราฟแสดง 7 วันล่าสุด
        $startDate = $hasDateFilter
            ? Carbon::parse($validated['start_date'])->startOfDay()
            : today()->subDays(6)->startOfDay();

        $endDate = $hasDateFilter
            ? Carbon::parse($validated['end_date'])->endOfDay()
            : today()->endOfDay();

        // ใช้เงื่อนไขนับยอดเหมือนระบบเดิม
        $baseQuery = Rental::query()
            ->where('status', '!=', 'rejected');

        $totalSales = (clone $baseQuery)->sum('total_price');

        $totalRentals = (clone $baseQuery)->count();

        $totalDresses = Dress::count();

        $pendingRentals = Rental::where('status', 'pending')->count();

        $availableDresses = Dress::where('status', 'available')->count();

        $rentingDresses = Dress::where('status', 'rented')->count();

        $todayQuery = (clone $baseQuery)
            ->whereBetween('created_at', [
                today()->startOfDay(),
                today()->endOfDay(),
            ]);

        $todaySales = (clone $todayQuery)->sum('total_price');

        $todayRentals = (clone $todayQuery)->count();

        $monthSales = (clone $baseQuery)
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->sum('total_price');

        // ป้องกันการข้ามเดือนผิดเมื่อวันนี้เป็นปลายเดือน
        $lastMonth = now()->startOfMonth()->subMonth();

        $lastMonthSales = (clone $baseQuery)
            ->whereBetween('created_at', [
                $lastMonth->copy()->startOfMonth(),
                $lastMonth->copy()->endOfMonth(),
            ])
            ->sum('total_price');

        $averageRental = $totalRentals > 0
            ? $totalSales / $totalRentals
            : 0;

        // สรุปยอดในช่วงวันที่เลือก
        $rangeQuery = (clone $baseQuery)
            ->whereBetween('created_at', [
                $startDate,
                $endDate,
            ]);

        $rangeSales = (clone $rangeQuery)->sum('total_price');

        $rangeRentals = (clone $rangeQuery)->count();

        $rangeAverage = $rangeRentals > 0
            ? $rangeSales / $rangeRentals
            : 0;

        // รวมยอดแต่ละวันจากฐานข้อมูล
        $dailySales = (clone $rangeQuery)
            ->selectRaw(
                'DATE(created_at) AS sales_date, SUM(total_price) AS sales_total'
            )
            ->groupByRaw('DATE(created_at)')
            ->orderBy('sales_date')
            ->pluck('sales_total', 'sales_date');

        // เติมวันที่ไม่มียอด เพื่อให้กราฟแสดงครบทุกวัน
        $chartData = collect();

        for (
            $date = $startDate->copy();
            $date->lte($endDate);
            $date->addDay()
        ) {
            $chartData->put(
                $date->format('d/m/Y'),
                (float) ($dailySales->get($date->format('Y-m-d')) ?? 0)
            );
        }

        return view('owner.dashboard', compact(
            'totalSales',
            'totalRentals',
            'totalDresses',
            'pendingRentals',
            'availableDresses',
            'rentingDresses',
            'todaySales',
            'todayRentals',
            'monthSales',
            'lastMonthSales',
            'averageRental',
            'hasDateFilter',
            'startDate',
            'endDate',
            'rangeSales',
            'rangeRentals',
            'rangeAverage',
            'chartData'
        ));
    }
}