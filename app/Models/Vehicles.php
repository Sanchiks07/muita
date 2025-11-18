<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model {
    protected $fillable = [
        'api_id',
        'plate_no',
        'country',
        'make',
        'model',
        'vin',
    ];
}
