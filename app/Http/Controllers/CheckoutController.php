<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Country;
use App\Models\Shipping;
use App\Models\Product;
use App\Models\DiscountCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\DB;
class CheckoutController extends Controller
{
public function index()
    {
            session()->forget('coupon');


        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->route('front.shop')->with('error', 'Your cart is empty!');
        }

        // Subtotal
        $subtotal = 0;
        foreach($cart as $item){
            $subtotal += $item['price'] * $item['qty'];
        }

        $shipping = 0; // default shipping
        $total = $subtotal + $shipping;

        $countries = Country::orderBy('name')->get();

     $discount = 0;

if(session()->has('coupon')){
    $discount = session()->get('coupon')['discount'];
}

$total = $subtotal + $shipping - $discount;


       return view('front.checkout', compact('cart','subtotal','shipping','total','countries','discount'));
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

   // Get shipping from shipping_charges table
$shippingRecord = shipping::where('country_id', $request->country)->first();

$shipping = $shippingRecord ? $shippingRecord->amount : 0;

// Calculate discount first
$discount = 0;

if(session()->has('coupon')){
    $discount = session()->get('coupon')['discount'];

    $coupon = DiscountCoupon::find(session()->get('coupon')['id']);
    if($coupon && $coupon->max_uses){
        $coupon->decrement('max_uses');
    }
}

// Final total AFTER discount
$grand_total = $subtotal + $shipping - $discount;
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
        $order->payment_method = $request->payment_method;
        $order->status = 'pending';

        // Debug: Check if order saves
        \Log::info('Attempting to save order', $order->toArray());

        $discount = 0;

if(session()->has('coupon')){

    $discount = session()->get('coupon')['discount'];

    // Reduce global max uses
    $coupon = DiscountCoupon::find(session()->get('coupon')['id']);
    if($coupon && $coupon->max_uses){
        $coupon->decrement('max_uses');
    }
}

// If Stripe selected, process payment first
if($request->payment_method == 'stripe') {

if($request->payment_method == 'stripe'){
    $request->validate([
        'stripeToken' => 'required'
    ]);
}

    Stripe::setApiKey(config('stripe.stripe.secret'));

    $charge = Charge::create([
        'amount' => $grand_total * 100, // convert to cents
        'currency' => 'usd',
        'source' => $request->stripeToken,
        'description' => 'Order Payment'
    ]);
    // dd($charge);

    // Optional: store transaction ID
    $order->payment_status = 'paid';
    $order->transaction_id = $charge->id;

} else {
    $order->payment_status = 'not_paid';
}



$grand_total = $subtotal + $shipping - $discount;

$order->discount = $discount;
$order->grand_total = $grand_total;

        $order->save();

$cart = session()->get('cart', []);

foreach ($cart as $id => $item) {
    $product = Product::find($id);

    if ($product && $product->track_qty == 'Yes') {
        $product->update(['qty' => max(0, $product->qty - $item['qty'])]);
    }
}

session()->forget('cart');


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

                session()->forget('coupon');


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
public function getShipping(Request $request)
{
    $shippingRecord = Shipping::where('country_id', $request->country_id)->first();
    $shipping = $shippingRecord ? $shippingRecord->amount : 0;

    return response()->json(['shipping' => $shipping]);
}

public function applyCoupon(Request $request)
{
    $request->validate([
        'code' => 'required'
    ]);

    $cart = session()->get('cart', []);

    if(empty($cart)){
        return response()->json([
            'status' => false,
            'message' => 'Cart is empty'
        ]);
    }

    // Calculate subtotal
    $subtotal = 0;
    foreach($cart as $item){
        $subtotal += $item['price'] * $item['qty'];
    }

    // Find coupon
    $coupon = DiscountCoupon::where('code', $request->code)
        ->where('status', 1)
        ->where('starts_at', '<=', Carbon::now())
        ->where('expires_at', '>=', Carbon::now())
        ->first();

    if(!$coupon){
        return response()->json([
            'status' => false,
            'message' => 'Invalid or expired coupon'
        ]);
    }

    // Minimum amount check
    if($subtotal < $coupon->min_amount){
        return response()->json([
            'status' => false,
            'message' => 'Minimum cart amount not reached'
        ]);
    }

    // Max uses check
    if($coupon->max_uses && $coupon->max_uses <= 0){
        return response()->json([
            'status' => false,
            'message' => 'Coupon usage limit reached'
        ]);
    }

    // Calculate discount
if($coupon->type === 'percent'){
    $percentage = min($coupon->discount_amount, 100);
    $discount = round(($subtotal * $percentage) / 100, 2);
} else {
    $discount = round($coupon->discount_amount, 2);
}

$discount = min($discount, $subtotal);

session()->put('coupon', [
    'id' => $coupon->id,
    'code' => $coupon->code,
    'discount' => $discount
]);
    // Prevent discount > subtotal
    if($discount > $subtotal){
        $discount = $subtotal;
    }

    // Store in session
    session()->put('coupon', [
        'id' => $coupon->id,
        'code' => $coupon->code,
        'discount' => $discount
    ]);

    return response()->json([
        'status' => true,
        'discount' => $discount
    ]);
}
}
