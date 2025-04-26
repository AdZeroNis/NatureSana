<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index()
   {
    $storeId = Auth::user()->store_id;
    
    if (Auth::user()->role == 'super_admin') {
        $products = Product::all();
    } else {
        $products = Product::where('store_id', $storeId)->get();
    }

    return view('Admin.Product.index', compact('products'));
   }

   public function create()
   {
    $storeId = Auth::user()->store_id;
    $categories = Category::where('store_id', $storeId)->get();
    return view('Admin.Product.create', compact('categories'));
   }

}
