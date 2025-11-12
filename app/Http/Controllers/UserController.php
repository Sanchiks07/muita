<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class users extends Controller
{
    public function index() {
        $muitaData = Http::get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['users'] as $user) {
            users::create([
                'api_id' => $user['id'],
                'name' => $user['usersname'],
                'full_name' => $user['full_name'],
                'role' => $user['role'],
                'active' => $user['active'],
                'password' => 'password123'
            ]);
        }

        return view('data')->with([
            'data' =>  $muitaData
        ]);
    }
}
