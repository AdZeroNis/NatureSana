<?php

namespace App\Http\Controllers\Home;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
public function index()
{
    $user = Auth::user();

    $orders = Order::with('orderItems.product')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('Home.order.index', compact('orders'));
}

}
