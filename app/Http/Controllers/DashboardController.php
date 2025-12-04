<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = collect();
        $documents = collect();
        $cases = collect();

        if (auth()->check() && auth()->user()->role === 'admin') {
            $users = DB::table('users')
                ->select('api_id', 'username', 'full_name', 'role', 'active')
                ->orderByRaw('CAST(api_id AS UNSIGNED)')
                ->paginate(15);
        } else if (auth()->check() && auth()->user()->role === 'broker') {
            $documents = DB::table('documents')
                ->select('api_id', 'case_id', 'filename', 'mime_type', 'category', 'pages', 'uploaded_by')
                ->orderByRaw('CAST(api_id AS UNSIGNED)')
                ->paginate(15);
        } else if (auth()->check() && auth()->user()->role === 'inspector' || auth()->user()->role === 'analyst') {
            $cases = DB::table('cases')
                ->select('api_id', 'external_ref', 'status', 'priority', 'arrival_ts', 'checkpoint_id', 'origin_country', 'destination_country', 'risk_flags', 'declarant_id', 'consignee_id', 'vehicle_id')
                ->orderByRaw('CAST(api_id AS UNSIGNED)')
                ->paginate(15);
        }

        return view('dashboard', compact('users', 'documents'));
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
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
