<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;

class ReturnController extends Controller
{
    public function index()
    {

        $rentals = Rental::with([
            'dress',
            'user',
        ])
            ->whereIn('status', [
                'approved',
                'renting',
            ])
            ->orderBy('end_date')
            ->get();

        return view(
            'admin.returns',
            compact('rentals')
        );

    }
}
