<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportController extends Controller
{
    public function export()
    {

        $rentals = Rental::with([
            'dress',
            'user',
        ])
            ->whereIn('status', [
                'approved',
                'renting',
                'returned',
            ])
            ->get();

        $totalSales = $rentals->sum('total_price');

        $pdf = Pdf::loadView(
            'owner.report-pdf',
            compact(
                'rentals',
                'totalSales'
            )
        );

        return $pdf->download(
            'rental-report.pdf'
        );

    }
}
