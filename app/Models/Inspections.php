<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspections extends Model {
    protected $fillable = [
        'api_id',
        'case_id',
        'type',
        'requested_by',
        'start_ts',
        'location',
        'checks',
        'assigned_to',
    ];
}
