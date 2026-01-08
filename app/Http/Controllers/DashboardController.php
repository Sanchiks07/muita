<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Services\CaseRiskService;
use Illuminate\Support\Facades\Cache;
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
                $query->where(function($q) use ($search) {
                    $q->where('api_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('username', 'LIKE BINARY', "%$search%")
                      ->orWhere('full_name', 'LIKE BINARY', "%$search%")
                      ->orWhere('role', 'LIKE BINARY', "%$search%");
                    
                    // Handle True/False search for active column
                    if (strtolower($search) === 'true') {
                        $q->orWhere('active', 1);
                    } elseif (strtolower($search) === 'false') {
                        $q->orWhere('active', 0);
                    }
                });
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
                ->select('api_id', 'external_ref', 'status', 'priority', 'arrival_ts', 'checkpoint_id', 'origin_country', 'destination_country', 'risk_flags', 'declarant_id', 'consignee_id', 'vehicle_id', 'hs_code')
                ->orderByRaw('CAST(api_id AS UNSIGNED)');
            
            if ($search) {
                $query->where('api_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('status', 'LIKE BINARY', "%$search%")
                      ->orWhere('priority', 'LIKE BINARY', "%$search%")
                      ->orWhere('checkpoint_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('origin_country', 'LIKE BINARY', "%$search%")
                      ->orWhere('destination_country', 'LIKE BINARY', "%$search%")
                      ->orWhere('declarant_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('consignee_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('vehicle_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('hs_code', 'LIKE BINARY', "%$search%");
            }
            
            $cases = $query->paginate(15);
        }

        // Optional admin-triggered full risk scan: add ?run_risk_scan=1 to URL
        $riskScanResults = null;
        if (auth()->check() && in_array(auth()->user()->role, ['analyst']) && request()->query('run_risk_scan') == '1') {
            $svc = new CaseRiskService();
            $riskScanResults = $svc->scanAll(30, auth()->user()->username);
            // store last scan globally in cache so other users can see popup
            Cache::put('last_risk_scan', $riskScanResults, now()->addHours(6));
        }

        // expose last run scan to the view for popup display to inspectors/analysts/admin
        $lastRiskScan = Cache::get('last_risk_scan');

        return view('dashboard', compact('users', 'documents', 'cases', 'riskScanResults', 'lastRiskScan'));
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

    /**
     * Show the dedicated risk scan page.
     */
    public function riskScan(Request $request)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['analyst'])) {
            abort(403);
        }

        $riskScanResults = null;
        if ($request->query('run_risk_scan') == '1') {
            $svc = new CaseRiskService();
            $riskScanResults = $svc->scanAll(30, auth()->user()->username);
            Cache::put('last_risk_scan', $riskScanResults, now()->addHours(6));
        }

        $lastRiskScan = Cache::get('last_risk_scan');

        return view('risk_scan', compact('lastRiskScan', 'riskScanResults'));
    }
}
