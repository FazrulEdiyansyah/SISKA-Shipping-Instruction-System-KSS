<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/shipping-instruction', function () {
    return view('shipping.shipping-instruction');
});

Route::post('/shipping-instruction', function (Illuminate\Http\Request $request) {
    $data = $request->only([
        'number', 'to', 'tugbarge', 'flag', 'shipper', 'consignee', 'notify_address',
        'port_loading', 'port_discharging', 'commodities', 'quantity', 'laycan', 'remarks',
        'place_date', 'signed_by', 'position'
    ]);
    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('shipping.shipping-instruction-pdf', $data);
    return $pdf->download('shipping-instruction.pdf');
});

Route::get('/ship-vendor-management', [VendorController::class, 'index'])->name('vendor.index');
Route::post('/ship-vendor-management', [VendorController::class, 'store'])->name('vendor.store');

Route::get('/approval-management', function () {
    return view('approval.approval-management');
});
