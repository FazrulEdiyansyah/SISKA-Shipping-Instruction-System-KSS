<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'to', 'tugbarge', 'flag', 'shipper', 'consignee', 'notify_address',
        'port_loading', 'port_discharging', 'commodities', 'quantity',
        'laycan_start', 'laycan_end', 'place', 'date',
        'signed_by', 'position', 'department', 'remarks',
        'spal_number', 'spal_document', 'completed_at'
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
        return $this->spal_number && $this->spal_document ? 'Completed' : 'Only SI';
    }
}
