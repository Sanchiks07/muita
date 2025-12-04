<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cases $cases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cases $cases)
    {
        if (! auth()->check() || auth()->case()->role !== 'inspector' || auth()->user()->role !== 'analyst') {
            abort(403);
        }

        $case = DB::table('cases')->where('api_id', $id)->first();

        if (! $case) {
            return redirect()->route('dashboard')->with('error', 'Case not found.');
        }

        return view('case_edit', compact('case'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cases $cases)
    {
        if (! auth()->check() || auth()->user()->role !== 'inspector' || auth()->user()->role !== 'analyst') {
            abort(403);
        }

        $data = $request->validate([
            'external_ref' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:255'],
            'checkpoint_id' => ['required', 'string', 'max:255'],
            'origin_country' => ['required', 'string', 'max:255'],
            'destination_country' => ['required', 'string', 'max:255'],
            'risk_flags' => ['required', 'string', 'max:255'],
            'declarant_id' => ['required', 'string', 'max:255'],
            'consignee_id' => ['required', 'string', 'max:255']
        ]);

        DB::table('users')->where('api_id', $id)->update([
            'external_ref' => $data['external_ref'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'checkpoint_id' => $data['checkpoint_id'],
            'origin_country' => $data['origin_country'],
            'destination_country' => $data['destination_country'],
            'risk_flags' => $data['risk_flags'],
            'declarant_id' => $data['declarant_id'],
            'consignee_id' => $data['consignee_id']
        ]);

        return redirect()->route('dashboard')->with('status', 'Case updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cases $cases)
    {
        if (! auth()->check() || auth()->user()->role !== 'inspector' || auth()->user()->role !== 'analyst') {
            abort(403);
        }

        DB::table('cases')->where('api_id', $id)->delete();

        return redirect()->route('dashboard')->with('status', 'Case deleted.');
    }
}
