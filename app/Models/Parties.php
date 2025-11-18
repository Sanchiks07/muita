<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parties extends Model {
    protected $fillable = [
        'api_id',
        'type',
        'name',
        'reg_code',
        'vat',
        'country',
        'email',
        'phone',
    ];
}
