<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;

class DocumentsController extends Controller
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
        if (! auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        return view('document_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        $data = $request->validate([
            'api_id' => ['required', 'string', 'max:255', 'unique:documents'],
            'case_id' => ['required', 'string', 'max:255'],
            'filename' => ['required', 'string', 'max:255'],
            'mime_type' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'pages' => ['required', 'integer'],
            'uploaded_by' => ['required', 'string', 'max:255']
        ]);

        DB::table('users')->insert([
            'api_id' => $data['api_id'],
            'case_id' => $data['case_id'],
            'filename' => $data['filename'],
            'mime_type' => $data['mime_type'],
            'category' => $data['category'],
            'pages' => $data['pages'],
            'uploaded_by' => $data['uploaded_by']
        ]);

        return redirect()->route('dashboard')->with('status', 'File uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Documents $documents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documents $documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documents $documents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documents $documents)
    {
        //
    }
}
