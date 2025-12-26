<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        return view('document_create');
    }

    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        $data = $request->validate([
            'api_id' => ['required', 'string', 'max:255', 'unique:documents,api_id'],
            'case_id' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'uploaded_by' => ['required', 'string', 'max:255'],
            'document' => ['required', 'file'],
            'pages' => ['nullable', 'integer']
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

    public function show(Documents $documents)
    {
        //
    }

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

    public function update(Request $request, string $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        $data = $request->validate([
            'api_id' => ['required', 'string', 'max:255'],
            'case_id' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'uploaded_by' => ['required', 'string', 'max:255'],
            'document' => ['nullable', 'file'],
            'pages' => ['nullable', 'integer']
        ]);

        $updateData = [
            'api_id' => $data['api_id'],
            'case_id' => $data['case_id'],
            'category' => $data['category'],
            'uploaded_by' => $data['uploaded_by'],
            'pages' => $data['pages'],
        ];

        // Only update file info if a new file was uploaded
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();

            $file->store('documents');

            $updateData['filename'] = $filename;
            $updateData['mime_type'] = $mimeType;
        }

        DB::table('documents')->where('api_id', $id)->update($updateData);

        return redirect()->route('dashboard')->with('status', 'Document updated successfully.');
    }

    public function destroy(string $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'broker') {
            abort(403);
        }

        DB::table('documents')->where('api_id', $id)->delete();

        return redirect()->route('dashboard')->with('status', 'Document deleted.');
    }
}