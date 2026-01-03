<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:inspector,analyst,broker,admin',
            'password' => 'required',
        ], [
            'role.required' => 'Please select your role before logging in.',
            'role.in' => 'The selected role is invalid.',
            'password.required' => 'You must enter a password.',
        ]);

        $user = User::where('role', $request->role)->first();

        if (!$user) {
            return back()->withErrors(['role' => 'No user found with this role'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => "You've inputed the wrong password"])->withInput();
        }

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
