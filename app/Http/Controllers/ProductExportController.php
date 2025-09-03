<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductExportController extends Controller
{
    public function exportAll()
    {
        $products = Product::all();
        $pdf = Pdf::loadView('exports.products', compact('products'));
        return $pdf->download('data-produk.pdf');
    }
}
