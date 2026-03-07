<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminAuthController extends Controller
{
    /* =======================
       SHOW LOGIN FORM
    ======================== */
    public function showLogin()
    {
        return view('admin.login'); // single login page for both
    }

      public function showregister()
    {
        return view('admin.register'); // single login page for both
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            // Remove role input from validation to prevent malicious role assignment
        ]);

        // Create user with default role as '1' (regular user)
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 1, // Regular user only
        ]);

        return redirect()->route('admin.login')
                         ->with('success', 'Registration successful! Please login.');
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
                return redirect()->route('admin.dashboard')
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


public function updatePersonal(Request $request)
{
    $user = Auth::user();

    // Validation
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id, // ignore current user
        'password' => 'nullable|string|min:8|confirmed', // only if changing
    ]);

    // Update user data
    $user->name = $request->name;
    $user->email = $request->email;

    // Update password only if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}


// Show Change Password Page
public function showChangePasswordForm()
{
    return view('admin.change-password');
}

// Handle Password Update
public function updatePassword(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'current_password'      => 'required',
        'password'              => 'required|string|min:8|confirmed',
    ]);

    // Check current password
    if (!\Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    // Update password
    $user->password = \Hash::make($request->password);
    $user->save();

    return redirect()->route('admin.dashboard')->with('success', 'Password changed successfully!');
}


    /* =======================
       LOGOUT
    ======================== */
   public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
                         ->with('success', 'Logged out successfully.');
    }
}
