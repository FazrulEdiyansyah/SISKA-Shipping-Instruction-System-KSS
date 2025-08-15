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
        'signed_by', 'position', 'department', 'remarks'
    ];
}
