<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\Slider;
use App\Models\Article;

class HomeController extends Controller
{
    public function home() {
        $latestItems = [
            'products' => Product::where('status', 1)
                                  ->orderBy('created_at', 'desc')
                                  ->take(10)
                                  ->get(),
    
            'stores' => Store::where('status', 1)
                              ->take(5)
                              ->get(),
    
            'sliders' => Slider::where('status', 1)
                                ->take(3)
                                ->get(),
        ];
    
        return view('Home.index', compact('latestItems'));
    }
}
