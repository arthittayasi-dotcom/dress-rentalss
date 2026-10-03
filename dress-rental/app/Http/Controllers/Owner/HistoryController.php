<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Rental;

class HistoryController extends Controller
{

    public function index()
    {

        $rentals = Rental::with([
            'dress',
            'user'
        ])
        ->latest()
        ->get();


        return view(
            'owner.history',
            compact('rentals')
        );

    }

}