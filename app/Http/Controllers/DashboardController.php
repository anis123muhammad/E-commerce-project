<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\ProductReview;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::count();

        // Total sales
        $totalSales = Order::sum('grand_total');

        // Revenue this month
        $revenueThisMonth = Order::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->sum('grand_total');

        // Revenue last month
        $revenueLastMonth = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
                                ->whereYear('created_at', Carbon::now()->subMonth()->year)
                                ->sum('grand_total');

        // Revenue last 30 days
        $revenueLast30Days = Order::where('created_at', '>=', Carbon::now()->subDays(30))
                                ->sum('grand_total');



        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalSales',
            'revenueThisMonth',
            'revenueLastMonth',
            'revenueLast30Days'
        ));
    }

    public function adminReviews()
{
    $reviews = ProductReview::with('product')->latest()->paginate(20);
    return view('admin.reviews.index', compact('reviews'));
}

public function approveReview($id)
{
    $review = ProductReview::findOrFail($id);
    $review->is_approved = true;
    $review->save();

    return back()->with('success', 'Review approved successfully.');
}

}
