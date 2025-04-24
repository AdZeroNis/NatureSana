<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        // $latestProducts = Product::where('status', 1)
        //                         ->orderBy('created_at', 'desc')
        //                         ->take(10)
        //                         ->get();

        // $stores = Store::all();
        // $sliders = Slider::all();

        return view('Home.index');
    }
}
