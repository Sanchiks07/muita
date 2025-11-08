<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class User extends Controller
{
    public function index() {
        $muitaData = Http::get('https://deskplan.lv/muita/app.json')->json();
        return view('data')->with([
            'data' =>  $muitaData
        ]);
    }
}
