<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'to', 'tugbarge', 'flag',
        'vessel_name', 'vessel_arrived', 'vessel_arrived_note',
        'shipper', 'consignee', 'notify_address',
        'port_loading', 'port_discharging', 'commodities', 'quantity',
        'laycan_start', 'laycan_end', 'place', 'date',
        'signed_by', 'remarks',
        'spal_number', 'spal_document',
        'mra_rab_document',
        'completed_at',
        'project_type',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public static function getShippingInstructions()
    {
        return self::orderBy('created_at', 'desc')->paginate(10);
    }

    // Method untuk mengecek status berdasarkan SPAL
    public function getStatusAttribute()
    {
        // Completed jika SPAL dan MRA & RAB sudah ada
        if (
            $this->spal_number && $this->spal_document && $this->mra_rab_document
        ) {
            return 'Completed';
        }
        // Incomplete jika salah satu/belum ada dokumen
        return 'Incomplete';
    }

    public function signatory()
    {
        return $this->belongsTo(Signatory::class, 'signed_by');
    }

    public static function generateNextNumber($vendorInitials)
    {
        $tahun = date('Y');
        $bulanRomawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $bulan = $bulanRomawi[intval(date('n'))];

        $lastSi = self::whereYear('created_at', $tahun)
            ->whereMonth('created_at', date('n'))
            ->orderByDesc('number')
            ->first();

        if ($lastSi && preg_match('/^(\d{3})\/SI\/KSS/', $lastSi->number, $matches)) {
            $lastNumber = (int)$matches[1];
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . "/SI/KSS-{$vendorInitials}/{$bulan}/{$tahun}";
    }

    public static function getSignatoryData($signed_by_id)
    {
        $signatory = \App\Models\Signatory::with('department')->find($signed_by_id);
        return [
            'signed_by_name' => $signatory ? $signatory->name : '',
            'position' => $signatory ? $signatory->position : '',
            'department' => $signatory && $signatory->department ? $signatory->department->name : '',
        ];
    }

    public static function formatLaycan($start, $end)
    {
        if ($start && $end) {
            $laycanStart = \Carbon\Carbon::parse($start);
            $laycanEnd = \Carbon\Carbon::parse($end);
            
            if ($laycanStart->format('Y') === $laycanEnd->format('Y') && $laycanStart->format('m') === $laycanEnd->format('m')) {
                return $laycanStart->format('d') . ' - ' . $laycanEnd->format('d F Y');
            } elseif ($laycanStart->format('Y') === $laycanEnd->format('Y')) {
                return $laycanStart->format('d F') . ' - ' . $laycanEnd->format('d F Y');
            } else {
                return $laycanStart->format('d F Y') . ' - ' . $laycanEnd->format('d F Y');
            }
        }
        return '-';
    }

    // Helper untuk data dari model (database)
    public static function prepareFromModel(self $si)
    {
        $data = $si->toArray();
        
        // Ambil data signatory jika ada
        if ($si->signatory) {
            $data['signed_by'] = $si->signatory->name;
            $data['signed_by_name'] = $si->signatory->name;
            $data['position'] = $si->signatory->position;
            $data['department'] = $si->signatory->department ? $si->signatory->department->name : '';
        } else {
            $data['signed_by'] = '-';
            $data['signed_by_name'] = '-';
            $data['position'] = '-';
            $data['department'] = '-';
        }
        
        return self::prepareData($data, true); // Pass true untuk indicate ini dari model (edit mode)
    }

    public static function prepareData($input, $isFromModel = false)
    {
        $data = $input;
        
        // Nomor SI - hanya generate jika belum ada dan bukan dari model (untuk create baru)
        if (!$isFromModel && empty($data['number']) && !empty($data['to'])) {
            $vendor = \App\Models\Vendor::where('company', $data['to'])->first();
            $initials = $vendor ? $vendor->initials : 'XXX';
            $data['number'] = self::generateNextNumber($initials);
        }
        
        // Laycan
        $data['laycan'] = self::formatLaycan($data['laycan_start'] ?? null, $data['laycan_end'] ?? null);
        
        // Place date
        $data['place_date'] = ($data['place'] ?? '') . ', ' . (\Carbon\Carbon::parse($data['date'] ?? now())->format('d F Y'));
        
        // Remarks
        $data['remarks'] = 'Freight Payable as Per Charter Party (SPAL)';
        
        // Tambahkan info signatory untuk kebutuhan tampilan (tidak untuk insert DB)
        if (!empty($data['signed_by']) && is_numeric($data['signed_by'])) {
            $signatoryData = self::getSignatoryData($data['signed_by']);
            $data = array_merge($data, $signatoryData);
        }
        $data['vessel_name'] = $input['vessel_name'] ?? null;
        $data['vessel_arrived'] = $input['vessel_arrived'] ?? null;
        $data['vessel_arrived_note'] = $input['vessel_arrived_note'] ?? null;
        $data['project_type'] = $input['project_type'] ?? 'default';
        return $data;
    }
}
