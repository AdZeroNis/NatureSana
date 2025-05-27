<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\StorePartnerProduct;
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
    
        $requestedQuantity = $request->input('quantity', 1);
        $partnerProductId = $request->input('partner_product_id');
    
        // Validate partner_product_id if provided
        if ($partnerProductId) {
            $partnerProduct = StorePartnerProduct::find($partnerProductId);
            if (!$partnerProduct || $partnerProduct->product_id !== $product->id) {
                $partnerProductId = null; // Set to null if invalid
            }
        }
    
        if ($product->inventory < $requestedQuantity) {
            $message = $product->inventory == 0
                ? 'این محصول موجود نیست'
                : 'تعداد محصولات کافی نیست. فقط ' . $product->inventory . ' عدد موجود است';
    
            return back()->with('error', $message);
        }
    
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->first();
    
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $requestedQuantity;
            if ($product->inventory < $newQuantity) {
                return back()->with('error', 'تعداد درخواستی بیشتر از موجودی است. حداکثر می‌توانید ' . ($product->inventory - $cartItem->quantity) . ' عدد دیگر اضافه کنید');
            }
    
            $cartItem->quantity = $newQuantity;
            $cartItem->partner_product_id = $partnerProductId; // Update partner_product_id
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $requestedQuantity,
                'partner_product_id' => $partnerProductId, // Store the correct partner_product_id
            ]);
        }
    
        $product->decrement('inventory', $requestedQuantity);
    
        $cartItems = Cart::with('product')
                        ->where('user_id', Auth::id())
                        ->get();
    
        $userId = Auth::id();
    
        return view('home.cart.index', compact('cartItems', 'userId')); 
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
