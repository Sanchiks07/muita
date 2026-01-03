<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        return view('document_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        $data = $request->validate([
            'api_id' => ['required', 'string', 'max:255', 'min:10', 'unique:documents,api_id'],
            'case_id' => ['required', 'string', 'max:255', 'min:11'],
            'category' => ['required', 'string', 'max:255'],
            'uploaded_by' => ['required', 'string', 'max:255', 'min:5'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,png'], // added file type
            'pages' => ['nullable', 'integer'],
        ]);

        $file = $request->file('document');
        $filename = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $file->store('documents');

        DB::table('documents')->insert([
            'api_id' => $data['api_id'],
            'case_id' => $data['case_id'],
            'filename' => $filename,
            'mime_type' => $mimeType,
            'category' => $data['category'],
            'pages' => $data['pages'],
            'uploaded_by' => $data['uploaded_by'],
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
    public function edit(string $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        $document = DB::table('documents')->where('api_id', $id)->first();

        if (!$document) {
            return redirect()->route('dashboard')->with('error', 'Document not found.');
        }

        return view('document_edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        $data = $request->validate([
            'case_id' => ['required', 'string', 'max:255', 'min:11'],
            'category' => ['required', 'string', 'max:255'],
            'uploaded_by' => ['required', 'string', 'max:255', 'min:5'],
            'document' => ['nullable', 'file', 'mimes:pdf,jpg,png'], // added file type
            'pages' => ['nullable', 'integer'],
        ]);

        $updateData = [
            'case_id' => $data['case_id'],
            'category' => $data['category'],
            'uploaded_by' => $data['uploaded_by'],
            'pages' => $data['pages'],
        ];

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $updateData['filename'] = $file->getClientOriginalName();
            $updateData['mime_type'] = $file->getMimeType();
            $file->store('documents');
        }

        DB::table('documents')->where('api_id', $id)->update($updateData);

        return redirect()->route('dashboard')->with('status', 'Document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        DB::table('documents')->where('api_id', $id)->delete();

        return redirect()->route('dashboard')->with('status', 'Document deleted.');
    }
}