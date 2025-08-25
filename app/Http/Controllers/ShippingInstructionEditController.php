<?php

namespace App\Http\Controllers;

use App\Models\ShippingInstruction;
use App\Models\Vendor;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShippingInstructionEditController extends Controller
{
    public function edit($id)
    {
        $si = ShippingInstruction::findOrFail($id);
        $vendors = Vendor::all();
        $signatories = Signatory::with('department')->get();
        
        return view('shipping.shipping-instruction-edit', compact('si', 'vendors', 'signatories'));
    }

    public function update(Request $request, $id)
    {
        $si = ShippingInstruction::findOrFail($id);

        // Validasi
        $request->validate([
            'to' => 'required|string',
            'tugbarge' => 'required|string',
            'flag' => 'required|string',
            'shipper' => 'required|string',
            'consignee' => 'required|string',
            'notify_address' => 'required|string',
            'port_loading' => 'required|string',
            'port_discharging' => 'required|string',
            'commodities' => 'required|string',
            'quantity' => 'required|string',
            'laycan_start' => 'required|date',
            'laycan_end' => 'required|date',
            'place' => 'required|string',
            'date' => 'required|date',
            'signed_by' => 'required|exists:signatories,id',
            'spal_number' => 'nullable|string',
            'spal_document' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Cek apakah vendor berubah
        $vendorChanged = $request->to !== $si->to;

        // Ambil inisial vendor baru
        $vendor = \App\Models\Vendor::where('company', $request->to)->first();
        $initials = $vendor ? $vendor->initials : 'XXX';

        // Jika vendor berubah, update nomor SI dengan inisial baru, urutan tetap
        $newNumber = $si->number;
        if ($vendorChanged) {
            if (preg_match('/^(\d{3})\/SI\/KSS-[^\/]+\/([IVXLCDM]+)\/(\d{4})$/', $si->number, $matches)) {
                $urut = $matches[1];
                $bulan = $matches[2];
                $tahun = $matches[3];
                $newNumber = "{$urut}/SI/KSS-{$initials}/{$bulan}/{$tahun}";
            }
        }

        // Handle SPAL document upload
        $spalDocument = $si->spal_document;
        if ($request->hasFile('spal_document')) {
            if ($si->spal_document && Storage::exists('public/spal_documents/' . $si->spal_document)) {
                Storage::delete('public/spal_documents/' . $si->spal_document);
            }
            $file = $request->file('spal_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/spal_documents', $fileName);
            $spalDocument = $fileName;
        }

        // Determine completed_at based on SPAL data
        $completedAt = null;
        if ($request->spal_number && $spalDocument) {
            $completedAt = now();
        }

        $si->update([
            'number' => $newNumber, // update nomor SI jika vendor berubah
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
            'remarks' => 'Freight Payable as Per Charter Party (SPAL)', // Set otomatis
            'spal_number' => $request->spal_number,
            'spal_document' => $spalDocument,
            'completed_at' => $completedAt,
        ]);
        
        return redirect()->route('shipping-instruction.detail', $id)
                        ->with('success', 'Shipping Instruction updated successfully!');
    }
}