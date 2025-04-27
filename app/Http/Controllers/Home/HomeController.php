<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\Slider;

class HomeController extends Controller
{
    public function home() {
        $latestProducts = Product::where('status', 1)
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();

        $stores = Store::all();
        $sliders = Slider::all();

        return view('Home.index', compact('latestProducts', 'stores', 'sliders'));
    }
}
