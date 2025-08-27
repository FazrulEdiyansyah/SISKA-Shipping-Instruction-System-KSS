<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Shipping Instruction - PT Krakatau Samudera Solusi</title>
    <style>
        @page { 
            margin: {{ $pageSettings['margin_top'] ?? 2.5 }}cm {{ $pageSettings['margin_right'] ?? 2 }}cm {{ $pageSettings['margin_bottom'] ?? 2.5 }}cm {{ $pageSettings['margin_left'] ?? 2 }}cm;
            @bottom-center {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 9px;
                color: #666;
                font-family: 'Arial', sans-serif;
            }
        }
        
        body { 
            font-family: 'Arial', 'Helvetica', sans-serif; 
            font-size: 11px; 
            color: #1a1a1a; 
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background: white;
        }
        
        /* Header Company */
        .company-header {
            position: relative;
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0 15px 0;
            border-bottom: 2px solid #0f172a;
        }
        
        /* Logo positioning */
        .logo-left {
            position: absolute;
            left: 0;
            top: 10px;
            height: 60px;
            width: auto;
        }
        
        .logo-right {
            position: absolute;
            right: 0;
            top: 15px;
            height: 70px;
            width: auto;
        }
        
        /* Header text with margin for logos */
        .header-content {
            margin: 0 80px;
            padding-top: 5px;
        }
        
        .company-name { 
            font-size: 22px; 
            font-weight: 700; 
            color: #0f172a;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .report-title { 
            font-size: 16px; 
            font-weight: 600; 
            color: #475569; 
            margin: 5px 0 8px 0; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .report-period { 
            font-size: 12px; 
            color: #64748b;
            font-weight: 500;
            margin: 8px 0 0 0;
        }
        
        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 9px;
            background: white;
            page-break-inside: auto;
        }
        
        .data-table thead {
            background: #00a0d2;
            border-top: 2px solid #0f172a;
            border-bottom: 1px solid #e2e8f0;
            display: table-header-group;
        }
        
        .data-table th {
            padding: 10px 6px;
            text-align: center; /* Tambahkan ini untuk rata tengah */
            font-weight: 600;
            font-size: 8px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            vertical-align: middle;
            word-wrap: break-word;
        }
        
        .data-table th:last-child {
            border-right: none;
        }
        
        .data-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
        
        .data-table tbody tr:nth-child(even) {
            background-color: #fafbfc;
        }
        
        .data-table td {
            padding: 8px;
            font-size: 9px;
            color: #374151;
            vertical-align: top;
            border-right: 1px solid #f1f5f9;
        }
        
        .data-table td:last-child {
            border-right: none;
        }
        
        /* Status Badges */
        .status-completed {
            background: #059669;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
            min-width: 60px;
        }
        
        .status-pending {
            background: #d97706;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
            min-width: 60px;
        }
        
        /* Document number styling */
        .doc-number {
            font-weight: 600;
            color: #0f172a;
            font-family: 'Courier New', monospace;
            font-size: 8px;
        }
        
        /* Date styling */
        .date-text {
            font-weight: 500;
            color: #374151;
            white-space: nowrap;
            font-size: 9px;
        }
        
        /* Summary Section */
        .summary-box {
            margin-top: 25px;
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }
        
        .summary-title {
            font-size: 11px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .summary-content {
            font-size: 10px;
            color: #475569;
            line-height: 1.5;
        }
        
        /* Footer */
        .report-footer { 
            position: fixed; 
            left: 0; 
            right: 0; 
            bottom: -20px; 
            font-size: 8px; 
            color: #64748b; 
            text-align: center;
            padding: 8px 0;
            border-top: 1px solid #e2e8f0;
            background: white;
        }
        
        /* Empty state */
        .no-data {
            text-align: center;
            padding: 30px;
            color: #64748b;
            font-style: italic;
            font-size: 11px;
        }
        
        /* Utility classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 600; }
        .nowrap { white-space: nowrap; }
        
        /* Print adjustments */
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .summary-box { break-inside: avoid; }
            .data-table thead { display: table-header-group; }
        }
    </style>
</head>
<body>
    <!-- Company Header -->
    <div class="company-header">
        <!-- Logo Kiri (KSS) -->
        <img src="{{ public_path('logo_kss.png') }}" alt="Logo KSS" class="logo-left">
        
        <!-- Logo Kanan (SISKA) -->
        <img src="{{ public_path('LogoSISKA.png') }}" alt="Logo SISKA" class="logo-right">
        
        <!-- Header Content -->
        <div class="header-content">
            <div class="company-name">PT Krakatau Samudera Solusi</div>
            <div class="report-title">Laporan Shipping Instruction</div>
            <div class="report-period">Periode: {{ $periodText }}</div>
        </div>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                @foreach($selectedColumns as $col)
                    <th>
                        @switch($col)
                            @case('date') Tanggal @break
                            @case('number') No. Dokumen @break
                            @case('to') Pemasok @break
                            @case('tugbarge') Tugboat/Barge @break
                            @case('shipper') Shipper @break
                            @case('commodities') Komoditas @break
                            @case('quantity') Kuantitas @break
                            @case('laycan') Laycan @break
                            @case('port_loading') Pelabuhan Muat @break
                            @case('port_discharging') Pelabuhan Bongkar @break
                            @case('spal_number') No. SPAL @break
                            @case('status') Status @break
                            @default {{ ucfirst(str_replace('_', ' ', $col)) }}
                        @endswitch
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $row)
            <tr>
                @foreach($selectedColumns as $col)
                    <td>
                        @switch($col)
                            @case('date')
                                <span class="date-text">{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</span>
                                @break
                            @case('number')
                                <span class="doc-number">{{ $row->number ?? '-' }}</span>
                                @break
                            @case('laycan')
                                <span class="nowrap">{{ \App\Models\ShippingInstruction::formatLaycan($row->laycan_start, $row->laycan_end) }}</span>
                                @break
                            @case('spal_number')
                                <span class="font-bold">{{ $row->spal_number ?? '-' }}</span>
                                @break
                            @case('status')
                                @if($row->spal_number && $row->spal_document && $row->mra_rab_document)
                                    <span class="status-completed">COMPLETED</span>
                                @else
                                    <span class="status-pending">INCOMPLETE</span>
                                @endif
                                @break
                            @case('quantity')
                                <span class="text-right">{{ $row->$col ?? '-' }}</span>
                                @break
                            @default
                                {{ $row->$col ?? '-' }}
                        @endswitch
                    </td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($selectedColumns) }}" class="no-data">
                    Tidak ada data shipping instruction pada periode yang dipilih
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary Section -->
    @if($reports->count() > 0)
    <div class="summary-box">
        <div class="summary-title">Ringkasan Laporan</div>
        <div class="summary-content">
            <strong>Total Dokumen:</strong> {{ $reports->count() }} shipping instruction<br>
            <strong>Dokumen Completed:</strong> {{ $reports->where('spal_number', '!=', null)->where('spal_document', '!=', null)->where('mra_rab_document', '!=', null)->count() }} dokumen<br>
            <strong>Only SI:</strong> {{ $reports->where('completed_at', null)->count() }} dokumen<br>
            <strong>Incomplete:</strong> {{ $reports->where(function($row) { return empty($row->spal_number) || empty($row->spal_document) || empty($row->mra_rab_document); })->count() }} dokumen<br>
            <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d F Y') }}
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="report-footer">
        PT Krakatau Samudera Solusi - SISKA System Report
    </div>
</body>
</html>