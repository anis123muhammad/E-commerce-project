<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Add to Cart
    public function add(Request $request)
    {
        $product = Product::with('images')->find($request->product_id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);

        // Product already in cart
        if (isset($cart[$product->id])) {
            // Check stock
            if ($product->track_qty == 'Yes' && $cart[$product->id]['qty'] >= $product->qty) {
                return redirect()->back()->with('error', 'No more products available in stock.');
            }
            $cart[$product->id]['qty']++;
        }
        // New product
        else {
            // Check stock
            if ($product->track_qty == 'Yes' && $product->qty < 1) {
                return redirect()->back()->with('error', 'No products available in stock.');
            }

            $cart[$product->id] = [
                "title" => $product->title,
                "image" => $product->images->first()->image ?? null,
                "price" => $product->price,
                "qty"   => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('front.cart.page');
    }

    // Show Cart
    public function cart()
    {
        return view("front.cart");
    }

    // Update Quantity (AJAX)
   public function update(Request $request)
{
    $cart = session()->get('cart', []);
    $id = $request->id;

    if (!isset($cart[$id])) {
        return response()->json(['success' => false, 'message' => 'Item not found in cart.']);
    }

if ($request->action == 'plus') {

    $product = Product::find($id);
    if ($product && $product->track_qty == 'Yes' && $cart[$id]['qty'] >= $product->qty) {
        return response()->json([
            'success' => false,
            'message' => 'Maximum available stock reached.'
        ]);
    }

    $cart[$id]['qty']++;
    $message = 'Item quantity increased.';      // ← ADD

} elseif ($request->action == 'minus') {
    if ($cart[$id]['qty'] > 1) {
        $cart[$id]['qty']--;
        $message = 'Item quantity decreased.';  // ← ADD
    } else {
        unset($cart[$id]);
        $message = 'Item removed from cart.';   // ← ADD
    }
}

session()->put('cart', $cart);
return $this->getCartData($message);  // ✅ now $message is always defined
    }

    // Remove Item (AJAX)
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
        }

        session()->put('cart', $cart);
        return $this->getCartData('Item removed.');
    }

    // Get Cart Data
    private function getCartData($message)
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart' => $cart,
            'subtotal' => number_format($subtotal, 2),
            'shipping' => '20.00',
            'total' => number_format($subtotal + 20, 2)
        ]);
    }
}
