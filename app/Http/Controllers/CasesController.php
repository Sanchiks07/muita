<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $muitaData = Http::get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['cases'] as $case) {
            Cases::create([
                'api_id' => $case['id'],
                'esxternal_ref' => $case['esxternal_ref'],
                'status' => $case['status'],
                'priority' => $case['priority'],
                'arrival_ts' => $case['arrival_ts'],
                'checkpoint_id' => $case['checkpoint_id'],
                'origin_country' => $case['origin_country'],
                'destination_country' => $case['destionation_country'],
                'risk_flags' => $case['risk_flags']
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
    public function show(Cases $cases) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cases $cases) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cases $cases) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cases $cases) {
        //
    }
}
