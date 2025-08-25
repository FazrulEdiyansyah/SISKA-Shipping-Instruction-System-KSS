<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <style>
        @page { 
            margin: {{ $pageSettings['margin_top'] ?? 2 }}cm {{ $pageSettings['margin_right'] ?? 1.5 }}cm {{ $pageSettings['margin_bottom'] ?? 2 }}cm {{ $pageSettings['margin_left'] ?? 1.5 }}cm;
        }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #222; }
        .header-section {
            text-align: {{ $pageSettings['header_align'] ?? 'center' }};
            margin-bottom: 20px;
            margin-top: 10px;
        }
        .company-name { 
            font-size: {{ ($pageSettings['header_size'] ?? 16) - 2 }}px; 
            font-weight: normal; 
            color: #000;
            margin-bottom: 5px;
            letter-spacing: 1px;
            line-height: 1.2;
        }
        .report-title { 
            font-size: {{ $pageSettings['header_size'] ?? 18 }}px; 
            font-weight: bold; 
            color: #b91c1c; 
            margin-bottom: 5px; 
            line-height: 1.2;
        }
        .period-text { 
            font-size: {{ ($pageSettings['header_size'] ?? 16) - 4 }}px; 
            color: #000;
            font-weight: normal;
            line-height: 1.2;
        }
        .footer { 
            position: fixed; 
            left: 0; 
            right: 0; 
            bottom: -30px; 
            font-size: {{ $pageSettings['footer_size'] ?? 11 }}px; 
            color: #333; 
            text-align: {{ $pageSettings['footer_align'] ?? 'center' }};
        }
        .nowrap { white-space: nowrap; }
    </style>
</head>
<body>
    @if(($pageSettings['show_header'] ?? true))
    <div class="header-section">
        @php
            $defaultHeader = "PT KRAKATAU SAMUDERA SOLUSI\nLaporan Dokumen Shipping Instruction";
            $headerText = trim($pageSettings['header_text'] ?? '') !== '' ? $pageSettings['header_text'] : $defaultHeader;
            $headerLines = explode("\n", $headerText);
        @endphp
        @foreach($headerLines as $index => $line)
            @if($index === 0)
                <div class="company-name">{{ trim($line) }}</div>
            @elseif($index === 1)
                <div class="report-title">{{ trim($line) }}</div>
            @else
                <div class="period-text">{{ trim($line) }}</div>
            @endif
        @endforeach
        <div class="period-text">Dari {{ $periodText }}</div>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                @foreach($selectedColumns as $col)
                    <th>
                        @switch($col)
                            @case('date') Tanggal @break
                            @case('number') Nomor @break
                            @case('tugbarge') Tugbarge @break
                            @case('shipper') Shipper @break
                            @case('commodities') Commodities @break
                            @case('quantity') Quantity @break
                            @case('laycan') Laycan @break
                            @case('spal_number') Nomor SPAL @break
                            @case('status') Status @break
                            @default {{ ucfirst($col) }}
                        @endswitch
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $row)
            <tr>
                @foreach($selectedColumns as $col)
                    <td>
                        @switch($col)
                            @case('date')
                                {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                                @break
                            @case('sub_total')
                            @case('total')
                            @case('request_total')
                                {{ number_format($row->$col ?? 0, 0, ',', '.') }}
                                @break
                            @case('description')
                                {!! nl2br(e($row->description ?? '-')) !!}
                                @break
                            @case('laycan')
                                {{ \App\Models\ShippingInstruction::formatLaycan($row->laycan_start, $row->laycan_end) }}
                                @break
                            @case('spal_number')
                                {{ $row->spal_number ?? '-' }}
                                @break
                            @case('status')
                                {{ $row->completed_at ? 'Completed' : 'Only SI' }}
                                @break
                            @default
                                {{ $row->$col ?? '-' }}
                        @endswitch
                    </td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($selectedColumns) }}" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(($pageSettings['show_footer'] ?? true))
    <div class="footer">
        @if(($pageSettings['show_print_date'] ?? false))
        <div style="float:left;">
            Tercetak pada {{ \Carbon\Carbon::now()->format('d F Y - H:i') }}
        </div>
        @endif
        <div style="text-align:center;">
            {{ trim($pageSettings['footer_text'] ?? 'SISKA System Report') }}
        </div>
        @if(($pageSettings['show_page_number'] ?? false))
        <div style="float:right;">
            Halaman {PAGE_NUM} dari {PAGE_COUNT}
        </div>
        @endif
    </div>
    @endif
</body>
</html>