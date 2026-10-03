<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)
            : Carbon::now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)
            : Carbon::now()->endOfMonth();

        // รายการเช่าที่นับเป็นรายได้จริง

        $rentals = Rental::with([
            'dress',
            'user',
        ])
            ->whereIn('status', [
                'approved',
                'renting',
                'returned',
            ])
            ->whereBetween(
                'created_at',
                [
                    $startDate->copy()->startOfDay(),
                    $endDate->copy()->endOfDay(),
                ]
            )
            ->get();

        // ยอดขายรวม

        $totalSales = $rentals->sum('total_price');

        // จำนวนรายการ

        $totalRentals = $rentals->count();

        // ยอดขายวันนี้

        $todaySales = Rental::whereIn('status', [
            'approved',
            'renting',
            'returned',
        ])
            ->whereDate(
                'created_at',
                today()
            )
            ->sum('total_price');

        // ยอดขายเดือนนี้

        $monthSales = Rental::whereIn('status', [
            'approved',
            'renting',
            'returned',
        ])
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->sum('total_price');

        // กราฟรายวัน

        $chartData = $rentals
            ->groupBy(function ($item) {

                return Carbon::parse(
                    $item->created_at
                )->format('d/m');

            })
            ->map(function ($items) {

                return $items->sum('total_price');

            });

        // ชุดยอดนิยม

        $popularDress = Rental::whereIn('status', [
            'approved',
            'renting',
            'returned',
        ])
            ->selectRaw(
                'dress_id, count(*) as total'
            )
            ->groupBy('dress_id')
            ->with('dress')
            ->orderByDesc('total')
            ->first();

        // รายการล่าสุด

        $latestRentals = Rental::with([
            'dress',
            'user',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view(
            'owner.reports',
            compact(
                'rentals',
                'totalSales',
                'totalRentals',
                'todaySales',
                'monthSales',
                'chartData',
                'startDate',
                'endDate',
                'popularDress',
                'latestRentals'
            )
        );

    }
}
