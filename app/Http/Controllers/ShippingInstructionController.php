<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    /**
     * Ambil inisial vendor dari nama vendor.
     * Contoh: "BERLIAN LINTAS TAMA" => "BLT"
     */
    private function getVendorInitial($vendor)
    {
        if (!$vendor) return '';
        return collect(explode(' ', $vendor))
            ->filter(fn($w) => trim($w) !== '')
            ->map(fn($w) => strtoupper($w[0]))
            ->join('');
    }
}