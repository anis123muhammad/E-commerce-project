<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){

    $featuredProducts  = Product::where('is_featured', 'yes')
                   ->where('status', 1)
                   ->orderBy('id', 'desc')
                   ->take(8)
                   ->with('firstImage')
                   ->get();


    $latestProducts = Product::where('status' , 1)
    ->orderBy('id','desc')
    ->take(8)
    ->with('firstImage')
    ->get();

        return view('front.home', compact('featuredProducts', 'latestProducts'));
    }
}
