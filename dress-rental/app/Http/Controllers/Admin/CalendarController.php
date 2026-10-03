<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {

        $month = request('month')
            ? Carbon::parse(request('month'))
            : Carbon::now();

        $rentals = Rental::with([
            'dress',
            'user',
        ])
            ->whereIn('status', [
                'pending',
                'approved',
                'renting',
            ])
            ->get();

        return view('admin.calendar', [

            'month' => $month,

            'rentals' => $rentals,

        ]);

    }
}
