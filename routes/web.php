<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalePrintController;
use App\Models\Service;
use App\Http\Controllers\SaleExportController;
use App\Http\Controllers\ProductExportController;

Route::get('/products/export/pdf', [ProductExportController::class, 'exportAll'])->name('products.export.pdf');


Route::get('/sales/{sale}/export-pdf', [SaleExportController::class, 'exportPdf'])->name('sales.export.pdf');
Route::get('/sales/export-all-pdf', [SaleExportController::class, 'exportAll'])
    ->name('sales.export.all.pdf');




Route::get('/services/{service}/print', function (Service $service) {
    $service->load('customer', 'details.product');

    return view('kwitansi', compact('service'));
})->name('services.print');

Route::get('/sales/{sale}/nota', [SalePrintController::class, 'show'])->name('sales.nota');


Route::get('/', function () {
    return redirect('/admin/login');
});