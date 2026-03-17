<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('dashboard.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {

            if (auth()->user()->role === 'admin' || auth()->user()->role === 'doctor') {
                $request->session()->regenerate();
                return redirect()->route('dashboard.index');
            }

            auth()->logout();

            return back()->withErrors([
                'email' => 'You do not have permission to access the dashboard.'
            ]);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.'
        ]);
    }
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show-login');
    }
}
