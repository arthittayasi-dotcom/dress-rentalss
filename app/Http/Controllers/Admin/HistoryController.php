<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;

class HistoryController extends Controller
{
    public function index()
    {

        $rentals = Rental::with([
            'dress',
            'user',
        ])
            ->whereIn('status', [
                'returned',
                'rejected',
                'cancelled',
            ])
            ->latest()
            ->get();

        return view(
            'admin.history',
            [
                'rentals' => $rentals,
            ]
        );

    }
}