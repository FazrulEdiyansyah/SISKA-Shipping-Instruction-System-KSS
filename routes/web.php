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
use Carbon\Carbon;

Route::get('/', function () {
    $totalShippingInstructions = \App\Models\ShippingInstruction::count();
    $totalVendors = \App\Models\Vendor::count();
    $totalSignatories = \App\Models\Signatory::count();
    $recentDocuments = \App\Models\ShippingInstruction::orderBy('created_at', 'desc')->take(5)->get();

    return view('dashboard', compact('totalShippingInstructions', 'totalVendors', 'totalSignatories', 'recentDocuments'));
});

Route::get('/shipping-instruction', function () {
    if (!request()->has('from_preview')) {
        session()->forget('si_preview_data');
    }
    $vendors = \App\Models\Vendor::all();
    $signatories = \App\Models\Signatory::with('department')->get();
    return view('shipping.shipping-instruction', compact('vendors', 'signatories'));
});

Route::post('/shipping-instruction', function (Illuminate\Http\Request $request) {
    // Ambil signatory berdasarkan ID
    $signatory = \App\Models\Signatory::with('department')->find($request->signed_by);
    $data = $request->only([
        'number', 'to', 'tugbarge', 'flag', 'shipper', 'consignee', 'notify_address',
        'port_loading', 'port_discharging', 'commodities', 'quantity', 'laycan', 'place_date'
    ]);
    $data['signed_by'] = $signatory ? $signatory->name : '';
    $data['position'] = $signatory ? $signatory->position : '';
    $data['department'] = $signatory && $signatory->department ? $signatory->department->name : '';
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
    $count = ShippingInstruction::whereYear('created_at', $tahun)
        ->whereMonth('created_at', date('n'))
        ->count() + 1;
    $number = str_pad($count, 3, '0', STR_PAD_LEFT) . "/SI/KSS-{$initials}/{$bulan}/{$tahun}";

    // Ambil signatory dari ID
    $signatory = \App\Models\Signatory::with('department')->find($request->signed_by);

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
        'signed_by' => $signatory ? $signatory->name : '',
        'remarks' => 'Freight Payable as Per Charter Party (SPAL)',
    ]);

    return redirect('/shipping-instruction')->with('success', 'Shipping Instruction saved successfully!');
});

Route::post('/shipping-instruction/preview-data', function (Illuminate\Http\Request $request) {
    session(['si_preview_data' => $request->all()]);
    return redirect('/shipping-instruction-preview');
});

Route::get('/shipping-instruction-preview', function () {
    $data = session('si_preview_data');
    if (!$data) {
        return redirect('/shipping-instruction')->with('error', 'No data to preview');
    }

    // Generate nomor jika belum ada
    if (empty($data['number'])) {
        $vendor = \App\Models\Vendor::where('company', $data['to'])->first();
        $initials = $vendor ? $vendor->initials : 'XXX';
        $tahun = date('Y');
        $bulanRomawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $bulan = $bulanRomawi[intval(date('n'))];
        $count = \App\Models\ShippingInstruction::whereYear('created_at', $tahun)
            ->whereMonth('created_at', date('n'))
            ->count() + 1;
        $data['number'] = str_pad($count, 3, '0', STR_PAD_LEFT) . "/SI/KSS-{$initials}/{$bulan}/{$tahun}";
        session(['si_preview_data' => $data]);
    }

    // Ambil data signatory dari ID jika masih ID
    if (!empty($data['signed_by']) && is_numeric($data['signed_by'])) {
        $signatory = \App\Models\Signatory::with('department')->find($data['signed_by']);
        $data['signed_by'] = $signatory ? $signatory->name : '';
        $data['position'] = $signatory ? $signatory->position : '';
        $data['department'] = $signatory && $signatory->department ? $signatory->department->name : '';
    }

    return view('shipping.shipping-instruction-preview', compact('data'));
});

Route::get('/shipping-instruction-preview/{id}', function ($id) {
    $si = \App\Models\ShippingInstruction::findOrFail($id);
    $vendors = \App\Models\Vendor::all();
    $signatories = \App\Models\Signatory::with('department')->get();

    // Siapkan data array untuk detail
    $data = [
        'number' => $si->number,
        'to' => $si->to,
        'tugbarge' => $si->tugbarge,
        'flag' => $si->flag,
        'shipper' => $si->shipper,
        'consignee' => $si->consignee,
        'notify_address' => $si->notify_address,
        'port_loading' => $si->port_loading,
        'port_discharging' => $si->port_discharging,
        'commodities' => $si->commodities,
        'quantity' => $si->quantity,
        'laycan_start' => $si->laycan_start,
        'laycan_end' => $si->laycan_end,
        'laycan' => $si->laycan_start && $si->laycan_end
            ? (\Carbon\Carbon::parse($si->laycan_start)->format('d F Y') . ' - ' . \Carbon\Carbon::parse($si->laycan_end)->format('d F Y'))
            : '-',
        'place_date' => $si->place . ', ' . (\Carbon\Carbon::parse($si->date)->format('d F Y')),
        'spal_number' => $si->spal_number,
        'spal_document' => $si->spal_document,
        'signed_by' => $si->signed_by,
        'position' => $si->position,
        'department' => $si->department,
    ];

    // --- Tambahkan blok ini ---
    if (!empty($si->signed_by) && is_numeric($si->signed_by)) {
        $signatory = \App\Models\Signatory::with('department')->find($si->signed_by);
        $data['signed_by'] = $signatory ? $signatory->name : '-';
        $data['position'] = $signatory ? $signatory->position : '-';
        $data['department'] = $signatory && $signatory->department ? $signatory->department->name : '-';
    }
    // --------------------------

    return view('shipping.shipping-instruction-detail', compact('si', 'vendors', 'signatories', 'data'));
})->name('shipping-instruction.detail');

Route::get('/shipping-instruction/preview-pdf', function () {
    $data = session('si_preview_data');
    if (!$data) abort(404);

    // Generate nomor jika belum ada
    if (empty($data['number'])) {
        $vendor = \App\Models\Vendor::where('company', $data['to'])->first();
        $initials = $vendor ? $vendor->initials : 'XXX';
        $tahun = date('Y');
        $bulanRomawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $bulan = $bulanRomawi[intval(date('n'))];
        $count = \App\Models\ShippingInstruction::whereYear('created_at', $tahun)
            ->whereMonth('created_at', date('n'))
            ->count() + 1;
        $data['number'] = str_pad($count, 3, '0', STR_PAD_LEFT) . "/SI/KSS-{$initials}/{$bulan}/{$tahun}";
        session(['si_preview_data' => $data]);
    }

    // Tambahkan ini agar signed_by selalu nama, bukan ID
    if (!empty($data['signed_by']) && is_numeric($data['signed_by'])) {
        $signatory = \App\Models\Signatory::with('department')->find($data['signed_by']);
        $data['signed_by'] = $signatory ? $signatory->name : '';
        $data['position'] = $signatory ? $signatory->position : '';
        $data['department'] = $signatory && $signatory->department ? $signatory->department->name : '';
    }

    // Saat menyiapkan data untuk PDF
    $laycanStart = isset($data['laycan_start']) ? Carbon::parse($data['laycan_start']) : null;
    $laycanEnd = isset($data['laycan_end']) ? Carbon::parse($data['laycan_end']) : null;

    if ($laycanStart && $laycanEnd) {
        if (
            $laycanStart->format('Y') === $laycanEnd->format('Y') &&
            $laycanStart->format('m') === $laycanEnd->format('m')
        ) {
            // Bulan & tahun sama: 21 - 26 July 2025
            $data['laycan'] = $laycanStart->format('d') . ' - ' . $laycanEnd->format('d F Y');
        } elseif ($laycanStart->format('Y') === $laycanEnd->format('Y')) {
            // Tahun sama, bulan beda: 21 July - 24 August 2025
            $data['laycan'] = $laycanStart->format('d F') . ' - ' . $laycanEnd->format('d F Y');
        } else {
            // Tahun beda: 21 July 2024 - 24 August 2025
            $data['laycan'] = $laycanStart->format('d F Y') . ' - ' . $laycanEnd->format('d F Y');
        }
    } else {
        $data['laycan'] = '-';
    }

    $data['place_date'] = $data['place'] . ', ' . \Carbon\Carbon::parse($data['date'])->format('d F Y');
    $data['remarks'] = 'Freight Payable as Per Charter Party (SPAL)';
    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('shipping.shipping-instruction-pdf', $data);
    return $pdf->stream('shipping-instruction-preview.pdf');
});

Route::get('/shipping-instruction-preview/download', function () {
    $data = session('si_preview_data');
    if (!$data) return redirect('/shipping-instruction')->with('error', 'No data to download');

    // Cek apakah SI sudah ada (misal: berdasarkan semua field unik)
    $existing = \App\Models\ShippingInstruction::where([
        'to' => $data['to'],
        'tugbarge' => $data['tugbarge'],
        'flag' => $data['flag'],
        'shipper' => $data['shipper'],
        'consignee' => $data['consignee'],
        'notify_address' => $data['notify_address'],
        'port_loading' => $data['port_loading'],
        'port_discharging' => $data['port_discharging'],
        'commodities' => $data['commodities'],
        'quantity' => $data['quantity'],
        'laycan_start' => $data['laycan_start'],
        'laycan_end' => $data['laycan_end'],
        'place' => $data['place'],
        'date' => $data['date'],
        'signed_by' => $data['signed_by'],
        'position' => $data['position'] ?? '',
        'department' => $data['department'] ?? '',
    ])->first();

    if ($existing) {
        $number = $existing->number;
    } else {
        // Generate nomor baru
        $vendor = \App\Models\Vendor::where('company', $data['to'])->first();
        $initials = $vendor ? $vendor->initials : 'XXX';
        $tahun = date('Y');
        $bulanRomawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $bulan = $bulanRomawi[intval(date('n'))];
        $count = \App\Models\ShippingInstruction::whereYear('created_at', $tahun)
            ->whereMonth('created_at', date('n'))
            ->count() + 1;
        $number = str_pad($count, 3, '0', STR_PAD_LEFT) . "/SI/KSS-{$initials}/{$bulan}/{$tahun}";

        \App\Models\ShippingInstruction::create([
            'number' => $number,
            'to' => $data['to'],
            'tugbarge' => $data['tugbarge'],
            'flag' => $data['flag'],
            'shipper' => $data['shipper'],
            'consignee' => $data['consignee'],
            'notify_address' => $data['notify_address'],
            'port_loading' => $data['port_loading'],
            'port_discharging' => $data['port_discharging'],
            'commodities' => $data['commodities'],
            'quantity' => $data['quantity'],
            'laycan_start' => $data['laycan_start'],
            'laycan_end' => $data['laycan_end'],
            'place' => $data['place'],
            'date' => $data['date'],
            'signed_by' => $data['signed_by'],
            'position' => $data['position'] ?? '',
            'department' => $data['department'] ?? '',
            'remarks' => 'Freight Payable as Per Charter Party (SPAL)',
        ]);
    }

    // --- Tambahkan blok ini agar signed_by, position, department selalu nama ---
    if (!empty($data['signed_by']) && is_numeric($data['signed_by'])) {
        $signatory = \App\Models\Signatory::with('department')->find($data['signed_by']);
        $data['signed_by'] = $signatory ? $signatory->name : '';
        $data['position'] = $signatory ? $signatory->position : '';
        $data['department'] = $signatory && $signatory->department ? $signatory->department->name : '';
    }
    // --------------------------------------------------------------------------

    // Format laycan (jika ingin sesuai aturan custom, gunakan logic yang sama seperti preview-pdf)
    $laycanStart = isset($data['laycan_start']) ? Carbon::parse($data['laycan_start']) : null;
    $laycanEnd = isset($data['laycan_end']) ? Carbon::parse($data['laycan_end']) : null;

    if ($laycanStart && $laycanEnd) {
        if (
            $laycanStart->format('Y') === $laycanEnd->format('Y') &&
            $laycanStart->format('m') === $laycanEnd->format('m')
        ) {
            $data['laycan'] = $laycanStart->format('d') . ' - ' . $laycanEnd->format('d F Y');
        } elseif ($laycanStart->format('Y') === $laycanEnd->format('Y')) {
            $data['laycan'] = $laycanStart->format('d F') . ' - ' . $laycanEnd->format('d F Y');
        } else {
            $data['laycan'] = $laycanStart->format('d F Y') . ' - ' . $laycanEnd->format('d F Y');
        }
    } else {
        $data['laycan'] = '-';
    }

    $data['number'] = $number;
    $data['place_date'] = $data['place'] . ', ' . \Carbon\Carbon::parse($data['date'])->format('d F Y');
    $data['remarks'] = 'Freight Payable as Per Charter Party (SPAL)';
    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('shipping.shipping-instruction-pdf', $data);

    return $pdf->download('shipping-instruction.pdf');
});

Route::get('/shipping-instruction-overview', function () {
    $shippingInstructions = \App\Models\ShippingInstruction::orderBy('created_at', 'desc')->paginate(10);
    return view('shipping.shipping-instruction-overview', compact('shippingInstructions'));
})->name('shipping-instruction.overview');

// Edit routes
Route::get('/shipping-instruction-edit/{id}', [App\Http\Controllers\ShippingInstructionEditController::class, 'edit'])
    ->name('shipping-instruction.edit');

Route::put('/shipping-instruction-update/{id}', [App\Http\Controllers\ShippingInstructionEditController::class, 'update'])
    ->name('shipping-instruction.update');

// Detail route (pastikan ada)
Route::get('/shipping-instruction-preview/{id}', function($id) {
    $si = \App\Models\ShippingInstruction::findOrFail($id);
    $vendors = \App\Models\Vendor::all();
    $signatories = \App\Models\Signatory::with('department')->get();

    // Siapkan data array untuk detail
    $data = [
        'number' => $si->number,
        'to' => $si->to,
        'tugbarge' => $si->tugbarge,
        'flag' => $si->flag,
        'shipper' => $si->shipper,
        'consignee' => $si->consignee,
        'notify_address' => $si->notify_address,
        'port_loading' => $si->port_loading,
        'port_discharging' => $si->port_discharging,
        'commodities' => $si->commodities,
        'quantity' => $si->quantity,
        'laycan_start' => $si->laycan_start,
        'laycan_end' => $si->laycan_end,
        'laycan' => $si->laycan_start && $si->laycan_end
            ? (\Carbon\Carbon::parse($si->laycan_start)->format('d F Y') . ' - ' . \Carbon\Carbon::parse($si->laycan_end)->format('d F Y'))
            : '-',
        'place_date' => $si->place . ', ' . (\Carbon\Carbon::parse($si->date)->format('d F Y')),
        'spal_number' => $si->spal_number,
        'spal_document' => $si->spal_document,
        'signed_by' => $si->signed_by,
        'position' => $si->position,
        'department' => $si->department,
    ];

    // --- Tambahkan blok ini ---
    if (!empty($si->signed_by) && is_numeric($si->signed_by)) {
        $signatory = \App\Models\Signatory::with('department')->find($si->signed_by);
        $data['signed_by'] = $signatory ? $signatory->name : '-';
        $data['position'] = $signatory ? $signatory->position : '-';
        $data['department'] = $signatory && $signatory->department ? $signatory->department->name : '-';
    }
    // --------------------------

    return view('shipping.shipping-instruction-detail', compact('si', 'vendors', 'signatories', 'data'));
})->name('shipping-instruction.detail');

Route::post('/shipping-instruction/update/{id}', function (Illuminate\Http\Request $request, $id) {
    $si = \App\Models\ShippingInstruction::findOrFail($id);

    // Update field utama SI
    $si->to = $request->to;
    $si->tugbarge = $request->tugbarge;
    $si->flag = $request->flag;
    $si->shipper = $request->shipper;
    $si->consignee = $request->consignee;
    $si->notify_address = $request->notify_address;
    $si->port_loading = $request->port_loading;
    $si->port_discharging = $request->port_discharging;
    $si->commodities = $request->commodities;
    $si->quantity = $request->quantity;
    $si->laycan_start = $request->laycan_start;
    $si->laycan_end = $request->laycan_end;
    $si->place = $request->place;
    $si->date = $request->date;
    $si->remarks = $request->remarks;
    if ($request->signed_by) {
        $signatory = \App\Models\Signatory::with('department')->find($request->signed_by);
        $si->signed_by = $signatory ? $signatory->name : '';
    }

    // Update SPAL
    $si->spal_number = $request->spal_number;

    // Handle file upload SPAL
    if ($request->hasFile('spal_document')) {
        // Hapus file lama jika ada
        if ($si->spal_document && \Storage::disk('public')->exists('spal_documents/' . $si->spal_document)) {
            \Storage::disk('public')->delete('spal_documents/' . $si->spal_document);
        }
        // Simpan file baru ke public/storage/spal_documents
        $file = $request->file('spal_document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('spal_documents', $fileName, 'public');
        $si->spal_document = $fileName;
    }

    // Status completed jika SPAL lengkap
    if ($si->spal_number && $si->spal_document) {
        $si->completed_at = now();
    } else {
        $si->completed_at = null;
    }

    $si->save();

    return redirect()->back()->with('success', 'Shipping Instruction updated successfully!');
});