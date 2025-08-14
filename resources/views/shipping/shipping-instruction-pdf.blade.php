<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shipping Instruction</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; color: #222; }
        .header { display: flex; align-items: center; margin-bottom: 10px; }
        .logo { width: 120px; margin-right: 16px; }
        .company-title { font-size: 22px; font-weight: bold; letter-spacing: 1px; }
        .company-sub { font-size: 13px; margin-top: -4px; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin: 16px 0 18px 0; font-size: 16pt; }
        .info-table { margin-bottom: 10px; }
        .info-table td { padding: 2px 8px 2px 0; vertical-align: top; }
        .bold { font-weight: bold; }
        .mt-2 { margin-top: 12px; }
        .mb-2 { margin-bottom: 12px; }
        .footer { position: fixed; left: 0; bottom: 0; width: 100%; font-size: 10pt; }
        .footer-table td { vertical-align: top; padding-right: 30px; }
        .signature { margin-top: 40px; margin-bottom: 10px; }
        .signed { font-weight: bold; }
        .address { font-size: 10pt; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('logo_kss.png') }}" class="logo" alt="Logo">
        <div>
            <div class="company-title">KRAKATAU</div>
            <div class="company-sub">GLOBAL SOLUTIONS</div>
        </div>
    </div>
    <div class="title">SHIPPING INSTRUCTION</div>
    <table class="info-table">
        <tr>
            <td width="90">Number</td>
            <td width="10">:</td>
            <td>{{ $number }}</td>
        </tr>
        <tr>
            <td>To</td>
            <td>:</td>
            <td class="bold">{{ $to }}</td>
        </tr>
    </table>
    <p>Dear sir/ madam,</p>
    <p>
        Referred to our shipped of Indonesian Steam Coal in Bulk, please be advised with following specify data to preparing related documents:
    </p>
    <table class="info-table">
        <tr>
            <td width="150">Tugboat/Barge</td>
            <td width="10">:</td>
            <td class="bold">{{ $tugbarge }}</td>
        </tr>
        <tr>
            <td>Flag</td>
            <td>:</td>
            <td>{{ $flag }}</td>
        </tr>
        <tr>
            <td>Shipper</td>
            <td>:</td>
            <td>{{ $shipper }}</td>
        </tr>
        <tr>
            <td>Consignee</td>
            <td>:</td>
            <td>{{ $consignee }}</td>
        </tr>
        <tr>
            <td>Notify Address</td>
            <td>:</td>
            <td>{{ $notify_address }}</td>
        </tr>
        <tr>
            <td>Port of Loading</td>
            <td>:</td>
            <td>{{ $port_loading }}</td>
        </tr>
        <tr>
            <td>Port of Discharging</td>
            <td>:</td>
            <td>{{ $port_discharging }}</td>
        </tr>
        <tr>
            <td>Commodities</td>
            <td>:</td>
            <td>{{ $commodities }}</td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td>:</td>
            <td>{{ $quantity }}</td>
        </tr>
        <tr>
            <td>Laycan</td>
            <td>:</td>
            <td>{{ $laycan }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td>{{ $remarks }}</td>
        </tr>
    </table>
    <div class="mt-2 mb-2">{{ $place_date }}</div>
    <div class="mb-2">
        Best Regards,<br>
        <span class="bold">PT KRAKATAU SAMUDERA SOLUSI</span>
    </div>
    <div class="signature">
        <span class="signed">{{ $signed_by }}</span><br>
        {{ $position }}
    </div>
    <div class="footer">
        <table class="footer-table" width="100%">
            <tr>
                <td width="50%">
                    <span class="bold">PT KRAKATAU SAMUDERA SOLUSI</span><br>
                    <span class="address">
                        KRAKATAU INTERNATIONAL PORT AREA / KBS PORT<br>
                        JL. MAYJEND. S. PARMAN KM. 13, KEC. CIWANDAN<br>
                        KOTA CILEGON, 42445, BANTEN - INDONESIA
                    </span>
                </td>
                <td width="50%">
                    <span class="bold">JAKARTA OFFICE</span><br>
                    <span class="address">
                        KRAKATAU STEEL BUILDING 9<sup>th</sup> FLOOR<br>
                        JL. JEND. GATOT SUBROTO KAV. 54, JAKARTA SELATAN, 12950 - INDONESIA
                    </span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>