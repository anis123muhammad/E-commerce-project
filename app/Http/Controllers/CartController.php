<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Add Product to Cart
public function add(Request $request)
{
    $product = Product::with('images')->find($request->product_id);

    $cart = session()->get('cart', []);

    $image = $product->images->first()->image ?? null;

    // Check if product already in cart
    if(isset($cart[$product->id])) {

        // If track_qty enabled
        if($product->track_qty == 'Yes') {

            // Check if adding 1 exceeds stock
            if($cart[$product->id]['qty'] < $product->qty) {
                $cart[$product->id]['qty'] += 1;
            } else {
                // Cannot add more than available stock
                return redirect()->back()->with('error', 'No more products available in stock.');
            }

        } else {
            // Track qty disabled → add normally
            $cart[$product->id]['qty'] += 1;
        }

    } else {
        // First time adding product
        if($product->track_qty == 'Yes' && $product->qty < 1) {
            return redirect()->back()->with('error', 'No products available in stock.');
        }

        $cart[$product->id] = [
            "title" => $product->title,
            "image" => $image,
            "price" => $product->price,
            "qty"   => 1
        ];
    }

    // Save updated cart
    session()->put('cart', $cart);

    // Go to cart page
    return redirect()->route('front.cart.page');
}


    // Show Cart Page
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view("front.cart", compact("cart"));
    }

    // Increase Quantity
public function plus($id)
{
    // 1️⃣ Get cart from session
    $cart = session()->get('cart');

    // 2️⃣ Check if product exists in cart
    if(isset($cart[$id])) {

        // 3️⃣ Get product from database
        $product = Product::find($id);

        // 4️⃣ Check if track_qty is enabled
        if($product->track_qty == 'Yes') {

            // 5️⃣ Check if current cart quantity is less than available product qty
            if($cart[$id]['qty'] < $product->qty) {
                $cart[$id]['qty']++;
            } else {
                // 6️⃣ Cannot add more than stock
                return redirect()->back()->with('error', 'No more products available in stock.');
            }

        } else {
            // Track qty disabled, just increase
            $cart[$id]['qty']++;
        }
    }

    // 7️⃣ Save updated cart to session
    session()->put('cart', $cart);

    // 8️⃣ Go back to cart page
    return redirect()->back();
}



// Decrease Quantity
public function minus($id)
{
    $cart = session()->get('cart');

    if(isset($cart[$id])) {

        if($cart[$id]['qty'] > 1) {
            $cart[$id]['qty']--;
        }
        else {
            unset($cart[$id]);
        }
    }

    session()->put('cart', $cart);

    return redirect()->back();
}


// Remove Product
public function remove($id)
{
    $cart = session()->get('cart');

    if(isset($cart[$id])) {
        unset($cart[$id]);
    }

    session()->put('cart', $cart);

    return redirect()->back();
}


}
