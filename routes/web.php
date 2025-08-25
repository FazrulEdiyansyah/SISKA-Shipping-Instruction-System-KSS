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
    $totalShippingInstructions = ShippingInstruction::count();
    $totalVendors = Vendor::count();
    $totalSignatories = \App\Models\Signatory::count();
    $recentDocuments = ShippingInstruction::orderBy('created_at', 'desc')->take(5)->get();

    return view('dashboard', compact('totalShippingInstructions', 'totalVendors', 'totalSignatories', 'recentDocuments'));
});

Route::get('/shipping-instruction', function () {
    if (!request()->has('from_preview')) {
        session()->forget('si_preview_data');
    }
    $vendors = Vendor::all();
    $signatories = \App\Models\Signatory::with('department')->get();
    return view('shipping.shipping-instruction', compact('vendors', 'signatories'));
});

Route::post('/shipping-instruction', function (Request $request) {
    $data = ShippingInstruction::prepareData($request->all());
    $pdf = Pdf::loadView('shipping.shipping-instruction-pdf', $data);
    return $pdf->download('shipping-instruction.pdf');
});

Route::post('/shipping-instruction/generate-number', function(Request $request) {
    $vendorName = $request->input('vendor');
    $vendor = Vendor::where('company', $vendorName)->first();
    $initials = $vendor ? $vendor->initials : 'XXX';
    $number = ShippingInstruction::generateNextNumber($initials);
    return response()->json(['number' => $number]);
});

Route::get('/ship-vendor-management', [VendorController::class, 'index'])->name('vendor.index');
Route::post('/ship-vendor-management', [VendorController::class, 'store'])->name('vendor.store');

Route::post('/signatories', [SignatoryController::class, 'store'])->name('signatories.store');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('/approval-management', function () {
    $signatories = \App\Models\Signatory::with('department')->get();
    $departments = \App\Models\Department::all();
    return view('approval.approval-management', compact('signatories', 'departments'));
})->name('approval.management');

Route::post('/shipping-instruction/save', function (Request $request) {
    $data = ShippingInstruction::prepareData($request->all());
    $si = ShippingInstruction::create($data);
    return redirect('/shipping-instruction')->with('success', 'Shipping Instruction saved successfully!');
});

Route::post('/shipping-instruction/preview-data', function (Request $request) {
    session(['si_preview_data' => $request->all()]);
    return redirect('/shipping-instruction-preview');
});

Route::get('/shipping-instruction-preview', function () {
    $data = session('si_preview_data');
    if (!$data) {
        return redirect('/shipping-instruction')->with('error', 'No data to preview');
    }
    $data = ShippingInstruction::prepareData($data);
    return view('shipping.shipping-instruction-preview', compact('data'));
});

Route::get('/shipping-instruction/preview-pdf', function () {
    $data = session('si_preview_data');
    if (!$data) abort(404);
    $data = ShippingInstruction::prepareData($data);
    $pdf = Pdf::loadView('shipping.shipping-instruction-pdf', $data);
    return $pdf->stream('shipping-instruction-preview.pdf');
});

Route::get('/shipping-instruction-preview/download', function () {
    $data = session('si_preview_data');
    if (!$data) return redirect('/shipping-instruction')->with('error', 'No data to download');
    $data = ShippingInstruction::prepareData($data);
    // Simpan ke database jika belum ada
    if (empty($data['id'])) {
        ShippingInstruction::create($data);
    }
    $pdf = Pdf::loadView('shipping.shipping-instruction-pdf', $data);
    return $pdf->download('shipping-instruction.pdf');
});

// Edit routes pakai controller
Route::get('/shipping-instruction-edit/{id}', [\App\Http\Controllers\ShippingInstructionEditController::class, 'edit'])->name('shipping-instruction.edit');
Route::put('/shipping-instruction-update/{id}', [\App\Http\Controllers\ShippingInstructionEditController::class, 'update'])->name('shipping-instruction.update');

// Detail route
Route::get('/shipping-instruction-preview/{id}', function($id) {
    $si = \App\Models\ShippingInstruction::with('signatory.department')->findOrFail($id);
    $data = \App\Models\ShippingInstruction::prepareFromModel($si);
    return view('shipping.shipping-instruction-detail', compact('si', 'data'));
})->name('shipping-instruction.detail');

Route::delete('/shipping-instruction-delete/{id}', function ($id) {
    $si = ShippingInstruction::findOrFail($id);
    $si->delete();
    return redirect('/shipping-instruction-overview')->with('success', 'Shipping Instruction deleted!');
});

Route::get('/shipping-instruction-overview', function () {
    $shippingInstructions = \App\Models\ShippingInstruction::orderBy('created_at', 'desc')->paginate(10);
    return view('shipping.shipping-instruction-overview', compact('shippingInstructions'));
});

// Tambahkan route ini
Route::get('/shipping-instruction/{id}/pdf', function ($id) {
    $si = \App\Models\ShippingInstruction::findOrFail($id);
    $data = \App\Models\ShippingInstruction::prepareFromModel($si);
    $pdf = Pdf::loadView('shipping.shipping-instruction-pdf', $data);
    return $pdf->stream('shipping-instruction.pdf');
});