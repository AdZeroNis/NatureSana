<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
public function store(Request $request, Product $product)
{
    if (!Auth::check()) {
        return redirect()->route('FormLogin')->with('error', 'ابتدا ورود کنید');
    }

    // دریافت تعداد درخواستی کاربر (پیش‌فرض 1)
    $requestedQuantity = $request->input('quantity', 1);

    // بررسی موجودی محصول
    if ($product->inventory < $requestedQuantity) {
        $message = $product->inventory == 0
            ? 'این محصول موجود نیست'
            : 'تعداد محصولات کافی نیست. فقط ' . $product->inventory . ' عدد موجود است';

        return back()->with('error', $message);
    }

    // پیدا کردن آیتم در سبد خرید یا ایجاد جدید
    $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();

    if ($cartItem) {
        // بررسی موجودی برای زمانی که آیتم از قبل در سبد وجود دارد
        $newQuantity = $cartItem->quantity + $requestedQuantity;
        if ($product->inventory < $newQuantity) {
            return back()->with('error', 'تعداد درخواستی بیشتر از موجودی است. حداکثر می‌توانید ' . ($product->inventory - $cartItem->quantity) . ' عدد دیگر اضافه کنید');
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();
    } else {
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $requestedQuantity
        ]);
    }

    // کاهش موجودی محصول
    $product->decrement('inventory', $requestedQuantity);

    // واکشی اطلاعات سبد خرید برای نمایش
    $cartItems = Cart::with('product')
                    ->where('user_id', Auth::id())
                    ->get();

   return view('home.cart.index',compact('cartItems'));
}


public function showCart()
{
    $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

    // واکشی آدرس‌ها برای کاربر لاگین شده
    $userAddress = DB::table('user_address')
                    ->where('user_id', Auth::id())
                    ->first();

    // اگر رکورد وجود داشت، آدرس‌ها را به آرایه تبدیل کن
    $addresses = $userAddress ? [
        $userAddress->address_one,
        $userAddress->address_two,
        $userAddress->address_three,
    ] : [];

    return view('home.cart.index', compact('cartItems', 'addresses'));
}


    public function increase(Cart $cartItem)
    {
        $cartItem->increment('quantity');
        return back();
    }

    public function decrease(Cart $cartItem)
    {
        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }
        return back();
    }

public function delete(Cart $cartItem)
{
    // ابتدا موجودی محصول را بازگردانید
    $product = Product::find($cartItem->product_id);
    $product->increment('inventory', $cartItem->quantity);

    // سپس آیتم را حذف کنید
    $cartItem->delete();

    return back()->with('success', 'محصول از سبد خرید حذف شد');
}

    // نهایی کردن خرید (پرداخت)
    public function checkout(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:1000',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'سبد خرید شما خالی است.');
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'address' => $request->address,
            'total_price' => $totalPrice + 50, // هزینه ارسال
            'status' => 0, // در حال پردازش
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // حذف سبد خرید پس از ثبت سفارش
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'سفارش شما با موفقیت ثبت شد.');
    }
}
