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
    // ... اعتبارسنجی و گرفتن آیتم‌های سبد کاربر
    $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

    // محاسبه مجموع قیمت کل
    $totalPrice = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    // ایجاد سفارش
    $order = Order::create([
        'user_id' => Auth::id(),
        'address' => $request->input('address'),
        'total_price' => $totalPrice + 50000,
        'status' => 0
    ]);

    foreach ($cartItems as $item) {
        $product = $item->product;

        $ownerStoreId = $product->store_id;        // مالک اصلی محصول
        $sellerStoreId = $item->partner_product_id; // فروشگاه ارجاع دهنده از سبد خرید

        $totalItemPrice = $product->price * $item->quantity + 50000;

        // اگر فروشنده مشخص بود و با مالک متفاوت بود، تقسیم سهم کنیم
        if ($sellerStoreId && $sellerStoreId != $ownerStoreId) {
            // تقسیم سهم: 80٪ مالک - 20٪ فروشنده
            $ownerShare = $totalItemPrice * 0.8;
            $sellerShare = $totalItemPrice * 0.2;
        } else {
            // فروش مستقیم مالک
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

        $product->decrement('inventory', $item->quantity);
    }

    Cart::where('user_id', Auth::id())->delete();

    return redirect()->route('home')->with('success', 'پرداخت با موفقیت انجام شد و سفارش شما ثبت گردید.');
}

}
