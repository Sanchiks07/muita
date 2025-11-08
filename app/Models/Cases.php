<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $fillable = [
        'api_id',
        'externale_ref',
        'status',
        'priority',
        'arrival_ts',
        'checkpoint_id',
        'origin_country',
        'destination_country',
        'risk_flags',
        'declarant_id',
        'consignee_id',
        'vehicle_id'
    ];
}
