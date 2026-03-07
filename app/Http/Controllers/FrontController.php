<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Page;
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

    public function page($slug){

    $page = Page::where('slug', $slug)->first();
    if($page == null){
        abort(404);
    }

    return view('front.page',[
        'page' => $page
    ]);

    }

}
