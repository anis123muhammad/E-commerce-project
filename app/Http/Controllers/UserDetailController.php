<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerAddress;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserDetailController extends Controller
{

    public function profile()
    {
        $user = Auth::user();
        $address = $user->address ?? null;
        $countries = \App\Models\Country::all();

        return view('front.account.profile', compact('user', 'address', 'countries'));
    }


    public function edit()
    {
        $user = Auth::user();                  // logged-in user
        $address = $user->address ?? null;     // address if exists
        $countries = \App\Models\Country::all(); // optional, for select

        return view('user_auth.settings', compact('user', 'address', 'countries'));
    }

    // Update personal info
    public function updatePersonal(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Personal info updated.');
    }

    // Update or create address
    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'country_id' => 'required|exists:countries,id',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
        ]);

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'first_name',
                'last_name',
                'email',
                'mobile',
                'country_id',
                'address',
                'apartment',
                'city',
                'state',
                'zip'
            ])
        );

        return redirect()->back()->with('success', 'Address updated.');
    }
}
