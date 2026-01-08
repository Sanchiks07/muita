<?php

namespace App\Http\Controllers;

use App\Models\Inspections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspections = collect();
        $search = request('search', '');

        if (auth()->check() && (auth()->user()->role === 'inspector')) {
            $query = DB::table('inspections')
                ->select('api_id', 'case_id', 'type', 'requested_by', 'start_ts', 'location', 'checks', 'assigned_to')
                ->orderByRaw('CAST(api_id AS UNSIGNED)');
            
            if ($search) {
                $query->where('api_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('case_id', 'LIKE BINARY', "%$search%")
                      ->orWhere('type', 'LIKE BINARY', "%$search%")
                      ->orWhere('requested_by', 'LIKE BINARY', "%$search%")
                      ->orWhere('start_ts', 'LIKE BINARY', "%$search%")
                      ->orWhere('location', 'LIKE BINARY', "%$search%")
                      ->orWhere('checks', 'LIKE BINARY', "%$search%")
                      ->orWhere('assigned_to', 'LIKE BINARY', "%$search%");
            }
            
            $inspections = $query->paginate(15);
        }

        return view('inspections', compact('inspections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector')) {
            abort(403);
        }

        return view('inspections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector')) {
            abort(403);
        }

        $data = $request->validate([
            'api_id' => ['required', 'string', 'max:255', 'min:11', 'unique:inspections,api_id'],
            'case_id' => ['required', 'string', 'max:255', 'min:11'],
            'type' => ['required', 'string', 'max:255'],
            'requested_by' => ['required', 'string', 'max:255'],
            'start_ts' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'checks' => ['required', 'array'],
            'checks.*.result' => ['required', 'in:pending,finding,ok'],
            'assigned_to' => ['required', 'string', 'max:255', 'min:5'],
        ]);

        // Convert dd/mm/yyyy HH:MM to Y-m-d\TH:i (UTC)
        $start = \DateTime::createFromFormat('Y-m-d\TH:i', $data['start_ts'], new \DateTimeZone('Europe/Riga'));
        if (!$start) {
            return back()->withErrors(['start_ts' => 'Invalid start date format.'])->withInput();
        }

        // Check if start date is in the past
        $now = new \DateTime('now', new \DateTimeZone('Europe/Riga'));
        if ($start < $now) {
            return back()->withErrors(['start_ts' => 'Start date cannot be in the past.'])->withInput();
        }

        // Convert to UTC ISO 8601 format
        $start->setTimezone(new \DateTimeZone('UTC'));
        $startTs = $start->format('Y-m-d\TH:i:s\Z');

        $checksJson = json_encode($request->checks, JSON_UNESCAPED_UNICODE);

        DB::table('inspections')->insert([
            'api_id' => $data['api_id'],
            'case_id' => $data['case_id'],
            'type' => $data['type'],
            'requested_by' => $data['requested_by'],
            'start_ts' => $startTs,
            'location' => $data['location'],
            'checks' => $checksJson,
            'assigned_to' => $data['assigned_to'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('inspections')->with('status', 'Inspection created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector')) {
            abort(403);
        }

        $inspection = DB::table('inspections')->where('api_id', $id)->first();

        if (!$inspection) {
            return redirect()->route('inspections')->with('error', 'Inspection not found.');
        }

        return view('inspections.show', compact('inspection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector')) {
            abort(403);
        }

        $inspection = DB::table('inspections')->where('api_id', $id)->first();

        if (!$inspection) {
            return redirect()->route('inspections')->with('error', 'Inspection not found.');
        }

        return view('inspections.edit', compact('inspection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'case_id' => ['required', 'string', 'max:255', 'min:11'],
            'type' => ['required', 'string', 'max:255'],
            'requested_by' => ['required', 'string', 'max:255'],
            'start_ts' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'checks' => ['required', 'array'],
            'checks.*.result' => ['required', 'in:pending,finding,ok'],
            'assigned_to' => ['required', 'string', 'max:255', 'min:5'],
        ]);

        // Convert dd/mm/yyyy HH:MM to Y-m-d\TH:i:s\Z (UTC)
        $start = \DateTime::createFromFormat('d/m/Y H:i', $data['start_ts'], new \DateTimeZone('Europe/Riga'));
        if (!$start) {
            return back()->withErrors(['start_ts' => 'Invalid start date format.'])->withInput();
        }

        // Check if arrival date is in the past
        $now = new \DateTime('now', new \DateTimeZone('Europe/Riga'));
        if ($start < $now) {
            return back()->withErrors(['start_ts' => 'Start date cannot be in the past.'])->withInput();
        }

        // Convert to UTC ISO 8601 format
        $start->setTimezone(new \DateTimeZone('UTC'));
        $startTs = $start->format('Y-m-d\TH:i:s\Z');

        $checksJson = json_encode($request->checks, JSON_UNESCAPED_UNICODE);

        DB::table('inspections')->where('api_id', $id)->update([
            'case_id' => $data['case_id'],
            'type' => $data['type'],
            'requested_by' => $data['requested_by'],
            'start_ts' => $startTs,
            'location' => $data['location'],
            'checks' => $checksJson,
            'assigned_to' => $data['assigned_to'],
        ]);

        return redirect()->route('inspections.show', $id)->with('status', 'Inspection updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->check() || (auth()->user()->role !== 'inspector')) {
            abort(403);
        }

        DB::table('inspections')->where('api_id', $id)->delete();

        return redirect()->route('inspections')->with('status', 'Inspection deleted.');
    }

    public function updateDecision(Request $request, $id)
    {
        $data = $request->validate([
            'decision' => ['nullable', 'in:release,hold,reject'],
            'explanation' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('inspections')->where('api_id', $id)->update([
            'decision' => $data['decision'] ?? null,
            'explanation' => $data['explanation'] ?? null,
        ]);

        return redirect()->route('inspections.show', $id)->with('status', 'Decision saved.');
    }
}
