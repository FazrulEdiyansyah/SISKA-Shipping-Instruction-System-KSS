<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SignatoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ShippingInstructionController;
use App\Models\ShippingInstruction;
use App\Models\Vendor;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/shipping-instruction', function () {
    $vendors = \App\Models\Vendor::all();
    $signatories = \App\Models\Signatory::with('department')->get();
    return view('shipping.shipping-instruction', compact('vendors', 'signatories'));
});

Route::post('/shipping-instruction', function (Illuminate\Http\Request $request) {
    $data = $request->only([
        'number', 'to', 'tugbarge', 'flag', 'shipper', 'consignee', 'notify_address',
        'port_loading', 'port_discharging', 'commodities', 'quantity', 'laycan', 'place_date', 'signed_by', 'position'
    ]);
    // Set remarks default
    $data['remarks'] = 'Freight Payable as Per Charter Party (SPAL)';
    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('shipping.shipping-instruction-pdf', $data);
    return $pdf->download('shipping-instruction.pdf');
});

Route::post('/shipping-instruction/generate-number', [ShippingInstructionController::class, 'generateDocumentNumber']);

Route::get('/ship-vendor-management', [VendorController::class, 'index'])->name('vendor.index');
Route::post('/ship-vendor-management', [VendorController::class, 'store'])->name('vendor.store');

Route::post('/signatories', [SignatoryController::class, 'store'])->name('signatories.store');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('/approval-management', function () {
    $signatories = \App\Models\Signatory::with('department')->get();
    $departments = \App\Models\Department::all();
    return view('approval.approval-management', compact('signatories', 'departments'));
})->name('approval.management');

Route::post('/shipping-instruction/save', function (Illuminate\Http\Request $request) {
    $vendor = Vendor::where('company', $request->to)->first();
    $initials = $vendor ? $vendor->initials : 'XXX';

    $tahun = date('Y');
    $bulanRomawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
    $bulan = $bulanRomawi[intval(date('n'))];
    // Nomor urut per bulan
    $count = ShippingInstruction::whereYear('created_at', $tahun)
        ->whereMonth('created_at', date('n'))
        ->count() + 1;
    $number = str_pad($count, 3, '0', STR_PAD_LEFT) . "/SI/KSS-{$initials}/{$bulan}/{$tahun}";

    $si = ShippingInstruction::create([
        'number' => $number,
        'to' => $request->to,
        'tugbarge' => $request->tugbarge,
        'flag' => $request->flag,
        'shipper' => $request->shipper,
        'consignee' => $request->consignee,
        'notify_address' => $request->notify_address,
        'port_loading' => $request->port_loading,
        'port_discharging' => $request->port_discharging,
        'commodities' => $request->commodities,
        'quantity' => $request->quantity,
        'laycan_start' => $request->laycan_start,
        'laycan_end' => $request->laycan_end,
        'place' => $request->place,
        'date' => $request->date,
        'signed_by' => $request->signed_by,
        'position' => $request->position,
        'department' => $request->department,
        'remarks' => 'Freight Payable as Per Charter Party (SPAL)',
    ]);

    return redirect('/shipping-instruction')->with('success', 'Shipping Instruction saved successfully!');
});