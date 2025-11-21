<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CasesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cases', [CasesController::class, 'index']);
Route::get('/cases/{case}', [CasesController::class, 'show']);