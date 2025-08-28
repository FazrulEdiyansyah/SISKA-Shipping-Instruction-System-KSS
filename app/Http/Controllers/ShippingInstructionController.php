<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ShippingInstructionController extends Controller
{
    /**
     * Generate Document Number for Shipping Instruction.
     * Format: 009/SI/KSS-BLT/VIII/2025
     */
    public function generateDocumentNumber(Request $request)
    {
        $vendorName = $request->input('vendor');
        $vendorInitial = $this->getVendorInitial($vendorName);

        // Hitung jumlah SI yang sudah ada (misal: tabel shipping_instructions)
        $count = DB::table('shipping_instructions')->count() + 1;
        $number = str_pad($count, 3, '0', STR_PAD_LEFT);

        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $month = (int) Carbon::now()->format('n');
        $romanMonth = $romanMonths[$month];
        $year = Carbon::now()->format('Y');

        $docNumber = "{$number}/SI/KSS-{$vendorInitial}/{$romanMonth}/{$year}";

        return response()->json(['document_number' => $docNumber]);
    }

    private function getVendorInitial($vendor)
    {
        if (!$vendor) return '';
        if (strtolower($vendor) === 'pt bunga teratai') {
            return 'BT';
        }
        return collect(explode(' ', $vendor))
            ->filter(fn($w) => trim($w) !== '')
            ->map(fn($w) => strtoupper($w[0]))
            ->join('');
    }

    public function index()
    {
        $shippingInstructions = \App\Models\ShippingInstruction::orderBy('created_at', 'desc')->paginate(10);

        $totalSI = \App\Models\ShippingInstruction::count();
        $totalCompleted = \App\Models\ShippingInstruction::whereNotNull('spal_number')
            ->whereNotNull('spal_document')
            ->whereNotNull('mra_rab_document')
            ->count();
        $totalIncomplete = $totalSI - $totalCompleted;

        return view('shipping.shipping-instruction-overview', compact('shippingInstructions', 'totalSI', 'totalCompleted', 'totalIncomplete'));
    }

    public function update(Request $request, $id)
    {
        $si = ShippingInstruction::findOrFail($id);

        if ($request->hasFile('mra_rab_document')) {

            if ($si->mra_rab_document && Storage::exists('public/mra_rab_documents/' . $si->mra_rab_document)) {
                Storage::delete('public/mra_rab_documents/' . $si->mra_rab_document);
            }
            $file = $request->file('mra_rab_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/mra_rab_documents', $fileName);
            $si->mra_rab_document = $fileName;
        }

        $si->save();

    }
}