<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shipping Instruction</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 1.6cm 1cm 2cm;
        }
        body {
            font-family: Verdana, Geneva, sans-serif;
            font-size: 15px;
            color: #222;
            line-height: 1.15;
        }
        .header {
            margin-bottom: 18px;
        }
        .logo {
            width: 220px;
        }
        .title {
            font-size: 17px;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
            margin-bottom: 18px;
        }
        .info-block {
            margin-bottom: 8px;
        }
        .info-label {
            display: inline-block;
            min-width: 70px;
        }
        .info-sep {
            display: inline-block;
            min-width: 10px;
        }
        .info-value {
            display: inline-block;
            font-weight: bold;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .main-table td {
            padding: 3px 6px 3px 0;
            vertical-align: top;
            font-family: Verdana, Geneva, sans-serif;
            font-size: 15px;
            line-height: 1.5;
        }
        .main-table td.label {
            width: 160px;
            font-weight: normal;
        }
        .main-table td.value {
            font-weight: bold;
        }
        .signature-block {
            margin-top: 40px;
            margin-bottom: 60px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0;
        }
        .signature-pos {
            margin-top: 0;
        }
        .fixed-footer {
            position: fixed;
            left: 0;
            bottom: -0.5cm; /* Lewati margin bawah 1cm */
            width: 100%;
            color: #223A53;
            font-size: 11px;
            font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
            background: #fff;
            padding: 0;
            line-height: 1.2;
        }
        .footer-table {
            width: 100%;
        }
        .footer-table td {
            vertical-align: top;
            padding-right: 20px;
        }
        /* Gambar dekorasi kanan */
        .right-decoration {
            position: fixed;
            top: 50%;
            right: -1.6cm;
            height: 160px;
            transform: translateY(-50%);
            z-index: 0;
        }
    </style>
</head>
<body>
    <!-- Gambar dekorasi kanan -->
    <img src="{{ public_path('asetpdf.png') }}" class="right-decoration" alt="Decoration" />

    <div class="header">
        <img src="{{ public_path('logo_kss.png') }}" class="logo">
    </div>
    <div class="title">SHIPPING INSTRUCTION</div>
    <br>
    <div class="info-block">
        <span class="info-label">Number</span>
        <span class="info-sep">:</span>
        <span class="info-value" style="font-weight:normal;">{{ $number ?? '-' }}</span>
    </div>
    <div class="info-block" style="margin-bottom: 24px;">
        <span class="info-label">To</span>
        <span class="info-sep">:</span>
        <span class="info-value">{{ $to ?? '-' }}</span>
    </div>

    <p>Dear sir/ madam,</p>
    <p>
        Referred to our shipped of <b>{{ $commodities ?? '-' }}</b>, please be advised with following specify data to preparing related documents:
    </p>

    <table class="main-table">
        <tr>
            <td class="label">Tugboat/Barge</td>
            <td class="value">: {{ $tugbarge ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Flag</td>
            <td>: {{ $flag ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Shipper</td>
            <td>: {{ $shipper ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Consignee</td>
            <td>: {{ $consignee ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Notify Address</td>
            <td>: {{ $notify_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Port of Loading</td>
            <td>: {{ $port_loading ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Port of Discharging</td>
            <td>: {{ $port_discharging ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Commodities</td>
            <td>: {{ $commodities ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Quantity</td>
            <td>: {{ $quantity ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Laycan</td>
            <td>: {{ $laycan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Remarks</td>
            <td>: "{{ $remarks ?? '-' }}"</td>
        </tr>
    </table>
    <br>
    <p>{{ $place_date ?? '-' }}</p>
    <br>
    <p>Best Regards,</p>
    <p style="font-weight:bold; margin-top:-8px; margin-bottom:0; line-height:1;">PT KRAKATAU SAMUDERA SOLUSI</p>
    <br><br><br>
    <div class="signature-block">
        <p class="signature-name">{{ $signed_by ?? '-' }}</p>
        <p class="signature-pos">{{ $position ?? '-' }} {{ $department ?? '-' }}</p>
    </div>

    <div class="fixed-footer">
        <table class="footer-table">
            <tr>
                <td style="width:60%;">
                    <span style="font-weight:bold; color:#223A53;">PT KRAKATAU SAMUDERA SOLUSI</span><br>
                    <span style="font-weight:bold; color:#223A53;">KRAKATAU INTERNATIONAL PORT AREA / KBS PORT</span><br>
                    <span style="color:#223A53;">JL. MAYJEND, S. PARMAN KM. 13, KEC. CIWANDAN<br>
                    KOTA CILEGON, 42445, BANTEN - INDONESIA</span>
                </td>
                <td style="width:40%;">
                    <span style="font-weight:bold; color:#223A53;">JAKARTA OFFICE</span><br>
                    <span style="color:#223A53;">KRAKATAU STEEL BUILDING 9<sup>TH</sup> FLOOR<br>
                    JL. JEND, GATOT SUBROTO KAV. 54, JAKARTA SELATAN, 12950 - INDONESIA</span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>