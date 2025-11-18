<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model {
    protected $fillable = [
        'api_id',
        'case_id',
        'filename',
        'mime_type',
        'category',
        'pages',
        'uploaded_by',
    ];
}
