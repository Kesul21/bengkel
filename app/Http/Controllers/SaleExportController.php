<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleExportController extends Controller
{
    public function exportPdf(Sale $sale)
    {
        $pdf = Pdf::loadView('exports.sale', compact('sale'));
        return $pdf->download('invoice-penjualan-' . $sale->id . '.pdf');
    }
    public function exportAll()
    {
        $sales = Sale::with('customer')->get();

        $pdf = Pdf::loadView('exports.sales-all', compact('sales'));
        return $pdf->download('laporan-semua-penjualan.pdf');
    }
}
