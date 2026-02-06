<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /* =======================
       SHOW LOGIN FORM
    ======================== */
    public function showLogin()
    {
        return view('admin.login'); // single login page for both
    }

    /* =======================
       LOGIN SUBMIT
    ======================== */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on role
            if ($user->role == 2) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome Admin!');
            }

            if ($user->role == 1) {
                return redirect()->route('user.dashboard')
                    ->with('success', 'Welcome User!');
            }

            // If role is invalid
            Auth::logout();
            return back()->withErrors([
                'email' => 'Unauthorized access.'
            ]);
        }

        return back()->withErrors([
            'email' => 'Invalid email or password'
        ]);
    }

    /* =======================
       LOGOUT
    ======================== */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Logged out successfully.');
    }
}
