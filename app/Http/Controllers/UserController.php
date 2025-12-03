<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user = DB::table('users')->where('api_id', $id)->first();

        if (! $user) {
            return redirect()->route('dashboard')->with('error', 'User not found.');
        }

        return view('user_show', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:inspector,analyst,broker,admin'],
            'active' => ['nullable'],
        ]);

        $active = $request->has('active') ? 1 : 0;

        DB::table('users')->where('api_id', $id)->update([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'role' => $data['role'],
            'active' => $active,
        ]);

        return redirect()->route('dashboard')->with('status', 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        DB::table('users')->where('api_id', $id)->delete();

        return redirect()->route('dashboard')->with('status', 'User deleted.');
    }
}
