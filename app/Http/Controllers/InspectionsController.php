<?php

namespace App\Http\Controllers;

use App\Models\Inspections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InspectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $muitaData = Http::get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['inspections'] as $inspection) {
            Inspections::create([
                'api_id' => $inspection['id'],
                'case_id' => $inspection['case_id'],
                'type' => $inspection['type'],
                'requested_by' => $inspection['requested_by'],
                'start_ts' => $inspection['start_ts'],
                'location' => $inspection['location'],
                'checks' => $inspection['checks']
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
    public function show(Inspections $inspections) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspections $inspections) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspections $inspections) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspections $inspections) {
        //
    }
}
