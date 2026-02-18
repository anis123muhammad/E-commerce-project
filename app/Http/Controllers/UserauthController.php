<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserauthController extends Controller
{
    // Show Login Page
    public function index()
    {
        return view('user_auth.login');
    }

    // Show Register Page
    public function view()
    {
        return view('user_auth.register');
    }

    // ✅ Register Functionality
    public function registerPost(Request $request)
    {
        // Validation
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'cpassword' => 'required|same:password',
        ]);

        // Create User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 1, // Default role = simple user
            'password' => Hash::make($request->password),
        ]);

        // Auto login after register
        Auth::login($user);

        // ✅ Check if there's an intended URL, otherwise go to home
        if (session()->has('url.intended')) {
            return redirect()->intended(route('front.checkout'));
        }

        return redirect()->route('front.home')->with('success', 'Registered Successfully!');
    }

    // ✅ Login Functionality
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // ✅ Check if there's an intended URL (like checkout)
            if (session()->has('url.intended')) {
                return redirect()->intended(route('front.checkout'));
            }

            // ✅ Otherwise, redirect to home page
            return redirect()->route('front.home')->with('success', 'Login Successful!');
        }

        return back()->with('error', 'Invalid Email or Password!');
    }

    // ✅ Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
