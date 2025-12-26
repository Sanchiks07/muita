<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector' && auth()->user()->role !== 'analyst')) {
            abort(403);
        }

        return view('case_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector' && auth()->user()->role !== 'analyst')) {
            abort(403);
        }

        $data = $request->validate([
            'api_id' => ['required', 'string', 'max:255', 'unique:cases,api_id'],
            'external_ref' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:255'],
            'arrival_ts' => ['required', 'date_format:Y-m-d\TH:i'],
            'checkpoint_id' => ['required', 'string', 'max:255'],
            'origin_country' => ['required', 'string', 'max:255'],
            'destination_country' => ['required', 'string', 'max:255'],
            'risk_flags' => ['nullable', 'string', 'max:1000'],
            'declarant_id' => ['required', 'string', 'max:255'],
            'consignee_id' => ['required', 'string', 'max:255'],
            'vehicle_id' => ['required', 'string', 'max:255'],
        ]);

        // Convert datetime-local format to database format
        $arrivalTs = str_replace('T', ' ', $data['arrival_ts']);

        DB::table('cases')->insert([
            'api_id' => $data['api_id'],
            'external_ref' => $data['external_ref'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'arrival_ts' => $arrivalTs,
            'checkpoint_id' => $data['checkpoint_id'],
            'origin_country' => $data['origin_country'],
            'destination_country' => $data['destination_country'],
            'risk_flags' => $data['risk_flags'] ?? null,
            'declarant_id' => $data['declarant_id'],
            'consignee_id' => $data['consignee_id'],
            'vehicle_id' => $data['vehicle_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Case created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector' && auth()->user()->role !== 'analyst')) {
            abort(403);
        }

        $case = DB::table('cases')->where('api_id', $id)->first();

        if (!$case) {
            return redirect()->route('dashboard')->with('error', 'Case not found.');
        }

        return view('case_show', compact('case'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector' && auth()->user()->role !== 'analyst')) {
            abort(403);
        }

        $case = DB::table('cases')->where('api_id', $id)->first();

        if (!$case) {
            return redirect()->route('dashboard')->with('error', 'Case not found.');
        }

        return view('case_edit', compact('case'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector' && auth()->user()->role !== 'analyst')) {
            abort(403);
        }

        $data = $request->validate([
            'external_ref' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:255'],
            'arrival_ts' => ['required', 'date_format:Y-m-d\TH:i'],
            'checkpoint_id' => ['required', 'string', 'max:255'],
            'origin_country' => ['required', 'string', 'max:255'],
            'destination_country' => ['required', 'string', 'max:255'],
            'risk_flags' => ['nullable', 'string', 'max:1000'],
            'declarant_id' => ['required', 'string', 'max:255'],
            'consignee_id' => ['required', 'string', 'max:255']
        ]);

        // Convert datetime-local format to database format
        $arrivalTs = str_replace('T', ' ', $data['arrival_ts']);

        DB::table('cases')->where('api_id', $id)->update([
            'external_ref' => $data['external_ref'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'arrival_ts' => $arrivalTs,
            'checkpoint_id' => $data['checkpoint_id'],
            'origin_country' => $data['origin_country'],
            'destination_country' => $data['destination_country'],
            'risk_flags' => $data['risk_flags'] ?? null,
            'declarant_id' => $data['declarant_id'],
            'consignee_id' => $data['consignee_id']
        ]);

        return redirect()->route('dashboard')->with('status', 'Case updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector' && auth()->user()->role !== 'analyst')) {
            abort(403);
        }

        DB::table('cases')->where('api_id', $id)->delete();

        return redirect()->route('dashboard')->with('status', 'Case deleted.');
    }
}
