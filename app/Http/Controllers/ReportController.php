<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingInstruction;
use App\Models\Vendor;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function show(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'columns' => 'array'
        ]);

        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $selectedColumns = $request->columns ?? ['number', 'date', 'to', 'status'];

        // Query data berdasarkan periode tanggal
        $shippingInstructions = ShippingInstruction::with(['signatory'])
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->orderBy('date', 'asc')
            ->get();

        // Hitung periode untuk judul laporan
        $periodText = $this->getPeriodText($dateFrom, $dateTo);

        return view('report.show', [
            'reports' => $shippingInstructions,
            'selectedColumns' => $selectedColumns,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'periodText' => $periodText,
            'filters' => $request->all()
        ]);
    }

    public function download(Request $request)
    {
        $format = $request->get('format', 'excel');
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $selectedColumns = $request->columns ?? ['number', 'date', 'to', 'status'];
        $pageSettings = $request->page_settings ?? [];

        $shippingInstructions = \App\Models\ShippingInstruction::whereBetween('date', [$dateFrom, $dateTo])
            ->orderBy('date', 'asc')
            ->get();

        $periodText = $this->getPeriodText($dateFrom, $dateTo);

        if ($format === 'pdf') {
            $pdf = \PDF::loadView('report.pdf', [
                'reports' => $shippingInstructions,
                'selectedColumns' => $selectedColumns,
                'periodText' => $periodText,
                'pageSettings' => $pageSettings
            ]);

            // Terapkan ukuran & orientasi kertas
            $pdf->setPaper(
                $pageSettings['paper_size'] ?? 'A4',
                $pageSettings['orientation'] ?? 'portrait'
            );

            return $pdf->download('laporan-shipping-instruction.pdf');
        }

        // Excel export akan diimplementasi nanti
        return response()->json(['message' => 'Excel export belum tersedia'], 501);
    }

    public function previewPdf(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $selectedColumns = $request->columns ?? ['number', 'date', 'to', 'status'];
        $pageSettings = $request->page_settings ?? [];

        $shippingInstructions = ShippingInstruction::whereBetween('date', [$dateFrom, $dateTo])
            ->orderBy('date', 'asc')
            ->get();

        $periodText = $this->getPeriodText($dateFrom, $dateTo);

        $pdf = \PDF::loadView('report.pdf', [
            'reports' => $shippingInstructions,
            'selectedColumns' => $selectedColumns,
            'periodText' => $periodText,
            'pageSettings' => $pageSettings
        ]);

        // Terapkan ukuran & orientasi kertas
        $pdf->setPaper(
            $pageSettings['paper_size'] ?? 'A4',
            $pageSettings['orientation'] ?? 'portrait'
        );

        return $pdf->stream('preview-laporan.pdf');
    }

    public function getAvailableColumns()
    {
        return response()->json([
            'columns' => [
                ['key' => 'date', 'name' => 'Tanggal', 'checked' => true],
                ['key' => 'number', 'name' => 'Nomor #', 'checked' => true],
                ['key' => 'to', 'name' => 'Pemasok', 'checked' => true],
                ['key' => 'tugbarge', 'name' => 'Tugbarge', 'checked' => false],
                ['key' => 'shipper', 'name' => 'Shipper', 'checked' => false],
                ['key' => 'laycan', 'name' => 'Laycan', 'checked' => false],
                ['key' => 'port_loading', 'name' => 'Port Loading', 'checked' => false],
                ['key' => 'port_discharging', 'name' => 'Port Discharging', 'checked' => false],
                ['key' => 'commodities', 'name' => 'Commodities', 'checked' => false],
                ['key' => 'quantity', 'name' => 'Quantity', 'checked' => false],
                ['key' => 'spal_number', 'name' => 'Nomor SPAL', 'checked' => false],
                ['key' => 'status', 'name' => 'Status', 'checked' => true],
            ]
        ]);
    }

    private function getPeriodText($dateFrom, $dateTo)
    {
        $from = Carbon::parse($dateFrom);
        $to = Carbon::parse($dateTo);
        
        return $from->format('d M Y') . ' s/d ' . $to->format('d M Y');
    }
}