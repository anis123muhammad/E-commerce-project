<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ThanksController extends Controller
{
    public function index(Request $request)
    {
        // Get the most recent order for the authenticated user
        $order = Order::where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('front.thanks', compact('order'));
    }
}
