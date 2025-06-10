<?php

namespace App\Http\Controllers\Home;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{  public function payment(Request $request)
    {
        // دریافت آدرس از فرم سبد خرید
        $address = $request->input('address');

        // دریافت آیتم‌های سبد خرید کاربر
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // محاسبه جمع کل
        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('home.payment.payment', [
            'address' => $address,
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

public function submitPayment(Request $request)
{
    $cartItems = Cart::where('user_id', Auth::id())
        ->with(['product', 'partnerProduct'])
        ->get();

    $totalPrice = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    $order = Order::create([
        'user_id' => Auth::id(),
        'address' => $request->input('address'),
        'total_price' => $totalPrice + 50000,
        'status' => 0
    ]);

    foreach ($cartItems as $item) {
        $product = $item->product;

        $ownerStoreId = $product->store_id;
       $sellerStoreId = $item->partner_store_id; // به‌جای گرفتن از relation مستقیم


        $totalItemPrice = $product->price * $item->quantity + 50000;

        if ($sellerStoreId && $sellerStoreId != $ownerStoreId) {
            $ownerShare = $totalItemPrice * 0.8;
            $sellerShare = $totalItemPrice * 0.2;
        } else {
            $ownerShare = $totalItemPrice;
            $sellerShare = null;
            $sellerStoreId = null;
        }

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $item->quantity,
            'price' => $product->price,
            'owner_store_id' => $ownerStoreId,
            'seller_store_id' => $sellerStoreId,
            'owner_share' => $ownerShare,
            'seller_share' => $sellerShare,
        ]);
    }

    Cart::where('user_id', Auth::id())->delete();

    return redirect()->route('home')->with('success', 'پرداخت با موفقیت انجام شد و سفارش شما ثبت گردید.');
}

}
