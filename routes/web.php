<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\InspectionsController;
use App\Http\Controllers\PartiesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;

Route::get('/', function () {
    return view('welcome');
});


