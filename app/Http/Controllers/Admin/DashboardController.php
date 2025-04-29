<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Store;
use App\Models\Article;
use App\Models\Slider;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'super_admin') {
            $usersCount = User::count();
            $productsCount = Product::count();
            $storesCount = Store::count();
            $articlesCount = Article::count();
        } elseif ($user->role === 'admin') {
            $store = Store::where('admin_id', $user->id)->first();
            $usersCount = 0;
            $storesCount = 1;
            $productsCount = Product::where('store_id', $store->id)->count();
            $articlesCount = Article::where('user_id', $user->id)->count();
        } else {
            return redirect()->route('login')->with('error', 'شما دسترسی لازم را ندارید.');
        }
    
        return view('Admin.Dashboard.dashboard', [
            'usersCount' => $usersCount,
            'productsCount' => $productsCount,
            'storesCount' => $storesCount,
            'articlesCount' => $articlesCount,
            'user' => $user,
        ]);
    }
    
    
}
