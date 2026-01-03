<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model {
    protected $fillable = [
        'api_id',
        'external_ref',
        'status',
        'priority',
        'arrival_ts',
        'checkpoint_id',
        'origin_country',
        'destination_country',
        'risk_flags',
        'declerant_id',
        'consignee_id',
        'vehicle_id',
        'hs_code',
    ];
}
