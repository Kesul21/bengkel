<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use PDF;

class SalePrintController extends Controller
{
    public function show(Sale $sale)
    {
        $sale->load('customer', 'saleItems.product');

        $pdf = PDF::loadView('pdf.sale_nota', compact('sale'))->setPaper('A5');

        return $pdf->stream("Nota-Penjualan-{$sale->id}.pdf");
    }
}
