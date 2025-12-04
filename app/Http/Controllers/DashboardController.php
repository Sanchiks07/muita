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
        $search = request('search', '');

        if (auth()->check() && auth()->user()->role === 'admin') {
            $query = DB::table('users')
                ->select('api_id', 'username', 'full_name', 'role', 'active')
                ->orderByRaw('CAST(api_id AS UNSIGNED)');
            
            if ($search) {
                $query->where('api_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('username', 'LIKE BINARY', "%$search%")
                      ->orWhere('full_name', 'LIKE BINARY', "%$search%")
                      ->orWhere('role', 'LIKE BINARY', "%$search%")
                      ->orWhere('active', 'LIKE BINARY', "%$search%");
            }
            
            $users = $query->paginate(15);
        }
        
        else if (auth()->check() && auth()->user()->role === 'broker') {
            $query = DB::table('documents')
                ->select('api_id', 'case_id', 'filename', 'mime_type', 'category', 'pages', 'uploaded_by')
                ->orderByRaw('CAST(api_id AS UNSIGNED)');
            
            if ($search) {
                $query->where('api_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('case_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('filename', 'LIKE BINARY', "%$search%")
                      ->orWhere('category', 'LIKE BINARY', "%$search%")
                      ->orWhere('uploaded_by', 'LIKE BINARY', "%$search%");
            }
            
            $documents = $query->paginate(15);
        }
        
        else if (auth()->check() && (auth()->user()->role === 'inspector' || auth()->user()->role === 'analyst')) {
            $query = DB::table('cases')
                ->select('api_id', 'external_ref', 'status', 'priority', 'arrival_ts', 'checkpoint_id', 'origin_country', 'destination_country', 'risk_flags', 'declarant_id', 'consignee_id', 'vehicle_id')
                ->orderByRaw('CAST(api_id AS UNSIGNED)');
            
            if ($search) {
                $query->where('api_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('status', 'LIKE BINARY', "%$search%")
                      ->orWhere('priority', 'LIKE BINARY', "%$search%")
                      ->orWhere('checkpoint_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('origin_country', 'LIKE BINARY', "%$search%")
                      ->orWhere('destination_country', 'LIKE BINARY', "%$search%")
                      ->orWhere('declarant_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('consignee_id', 'LIKE BINARY', "%$search%");
            }
            
            $cases = $query->paginate(15);
        }

        return view('dashboard', compact('users', 'documents', 'cases'));
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
