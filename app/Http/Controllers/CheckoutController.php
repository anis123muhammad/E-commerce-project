<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get cart from session
        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->route('front.shop')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach($cart as $item){
            $subtotal += $item['price'] * $item['qty'];
        }

        $shipping = 20; // fixed shipping
        $total = $subtotal + $shipping;
        $countries = Country::orderBy('name')->get();

        return view('front.checkout', compact('cart', 'subtotal', 'shipping', 'total', 'countries'));
    }

public function processCheckout(Request $request)
{
    // Validate the request
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'country' => 'required',
        'address' => 'required|string',
        'city' => 'required|string',
        'state' => 'required|string',
        'zip' => 'required|string',
        'mobile' => 'required|string',
        'payment_method' => 'required|in:cod,stripe',
    ]);

    // Check if payment method is COD
    if($request->payment_method !== 'cod') {
        return redirect()->back()->with('error', 'Only COD is available at the moment.');
    }

    // Get cart from session
    $cart = session()->get('cart', []);

    if(empty($cart)) {
        return redirect()->route('front.shop')->with('error', 'Your cart is empty!');
    }

    // Calculate totals
    $subtotal = 0;
    foreach($cart as $item){
        $subtotal += $item['price'] * $item['qty'];
    }
    $shipping = 20;
    $grand_total = $subtotal + $shipping;

    // Use database transaction
    DB::beginTransaction();

    try {
        // Create the order
        $order = new Order();
        $order->user_id = auth()->id();
        $order->subtotal = $subtotal;
        $order->shipping = $shipping;
        $order->grand_total = $grand_total;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->country_id = $request->country;
        $order->address = $request->address;
        $order->apartment = $request->appartment;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->zip = $request->zip;
        $order->notes = $request->order_notes;
        $order->payment_method = 'cod';
        $order->status = 'pending';

        // Debug: Check if order saves
        \Log::info('Attempting to save order', $order->toArray());

        $order->save();

        \Log::info('Order saved successfully with ID: ' . $order->id);

        // Create order items
        foreach($cart as $id => $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $id;
            $orderItem->name = $item['title'];
            $orderItem->qty = $item['qty'];
            $orderItem->price = $item['price'];
            $orderItem->total = $item['price'] * $item['qty'];
            $orderItem->save();

            \Log::info('Order item saved for product: ' . $item['title']);
        }

        // Commit transaction
        DB::commit();

        // Clear the cart from session
        session()->forget('cart');

        // Redirect to thanks page with success message
        return redirect()->route('front.thanks')->with('success', 'Order placed successfully!');

    } catch (\Exception $e) {
        // Rollback transaction on error
        DB::rollback();

        // Log the error with more details
        \Log::error('Order processing failed: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());

        // Redirect back with error
        return redirect()->back()
            ->with('error', 'Something went wrong: ' . $e->getMessage())
            ->withInput();
    }
}
}
