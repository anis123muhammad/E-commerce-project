<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class ShopController extends Controller
{
public function index(Request $request)
{
    // Categories Sidebar
    $categories = Category::with('sub_categories')
        ->where('status', 1)
        ->orderBy('name', 'asc')
        ->get();

    // Brands Sidebar
    $brands = Brand::where('status', 1)
        ->orderBy('name', 'asc')
        ->get();

    // Products Query with Relationships
    $products = Product::with(['images', 'brand'])->where('status', 1);

    // Filter by Category
    if ($request->filled('category')) {
        $products->where('category_id', $request->category);
    }

    // Filter by SubCategory
    if ($request->filled('subcategory')) {
        $products->where('sub_category_id', $request->subcategory);
    }
// Filter by Price
if ($request->filled('min_price') && $request->filled('max_price')) {
    $products->whereBetween('price', [$request->min_price, $request->max_price]);
}

// Filter by Brands
if ($request->filled('brands') && is_array($request->brands)) {
    $products->whereIn('brand_id', $request->brands);
}


// ✅ Sorting Filter
if ($request->sort == "latest") {
    $products->orderBy("id", "desc");
}

if ($request->sort == "price_high") {
    $products->orderBy("price", "desc");
}

if ($request->sort == "price_low") {
    $products->orderBy("price", "asc");
}



    // Final Products with Pagination
    $products = $products->orderBy('id', 'desc')->paginate(9);

    return view('front.shop', compact('categories', 'brands', 'products'));
}



}
