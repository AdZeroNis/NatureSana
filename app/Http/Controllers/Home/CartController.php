<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\StorePartner;
use Illuminate\Http\Request;
use App\Models\StorePartnerProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
public function store(Request $request, Product $product)
{
    $request->validate([
        'partner_product_id' => 'nullable|exists:partner_products,id',
        'partner_store_id' => 'nullable|exists:stores,id'
    ]);

    // بررسی وضعیت فروشگاه اصلی محصول
    if ($product->store->status == 0) {
        return back()->with('error', 'فروشگاه این محصول در حال حاضر غیرفعال است.');
    }

    // اگر محصول از طریق همکاری اضافه شده باشد، بررسی وضعیت فروشگاه شریک
    if ($request->partner_store_id) {
        $partnerStore = Store::find($request->partner_store_id);
        if ($partnerStore->status == 0) {
            return back()->with('error', 'فروشگاه شریک در حال حاضر غیرفعال است.');
        }
    }

    // بررسی وضعیت خود محصول
    if ($product->status == 0) {
        return back()->with('error', 'این محصول در حال حاضر غیرفعال است.');
    }

    // بررسی موجودی محصول
    if ($product->inventory <= 0) {
        return back()->with('error', 'این محصول در حال حاضر ناموجود است.');
    }

    $cartData = [
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'quantity' => 1
    ];

    // اگر از طریق همکاری اضافه شده باشد
    if ($request->partner_product_id && $request->partner_store_id) {
        $cartData['partner_product_id'] = $request->partner_product_id;
        $cartData['partner_store_id'] = $request->partner_store_id;
    }

    Cart::create($cartData);

    return back()->with('success', 'محصول به سبد خرید اضافه شد.');
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

    $userId = Auth::id(); // آیدی کاربر

    return view('home.cart.index', compact('cartItems', 'addresses', 'userId'));
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
public function update(Request $request, $id)
{
    $cartItem = Cart::find($id);
    $product = Product::find($cartItem->product_id);

    if ($request->action === 'increase') {
        if ($product->inventory > 0) {
            $cartItem->quantity += 1;
            $product->decrement('inventory', 1);
        } else {
            return redirect()->back()->with('error', 'موجودی کافی برای افزایش تعداد وجود ندارد.');
        }
    } elseif ($request->action === 'decrease') {
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $product->increment('inventory', 1);
        } else {
            return redirect()->back()->with('error', 'حداقل تعداد باید یک باشد.');
        }
    }

    $cartItem->save();
    $product->save();

    return redirect()->back()->with('success', 'تعداد محصول به‌روز شد.');
}



}
