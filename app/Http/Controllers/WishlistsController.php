<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistsController extends Controller
{
    // Toggle wishlist (add or remove)
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Please login to add wishlist.'
            ]);
        }

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            // Already in wishlist → remove it
            $existing->delete();
            return response()->json([
                'status' => true,
                'action' => 'removed',
                'message' => 'Removed from wishlist.'
            ]);
        }

        // Not in wishlist → add it (1 product only once)
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'status' => true,
            'action' => 'added',
            'message' => 'Added to wishlist.'
        ]);
    }

    // Show wishlist page
    public function index()
    {
        $wishlists = Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('front.account.wishlist', compact('wishlists'));
    }

    // Remove from wishlist page
    public function remove($id)
    {
        Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Removed from wishlist.');
    }
}
