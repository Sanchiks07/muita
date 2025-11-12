<?php

namespace App\Http\Controllers;

use App\Models\Parties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PartiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $muitaData = Http::get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['parties'] as $party) {
            Parties::create([
                'api_id' => $party['id'],
                'type' => $party['type'],
                'name' => $party['name'],
                'reg_code' => $party['reg_code'],
                'vat' => $party['vat'],
                'country' => $party['country'],
                'email' => $party['email'],
                'phone' => $party['phone']
            ]);
        }

        return view('data')->with([
            'data' =>  $muitaData
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Parties $parties) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parties $parties) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parties $parties) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parties $parties) {
        //
    }
}
