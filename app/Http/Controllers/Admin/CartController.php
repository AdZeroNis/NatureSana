<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\StorePartner;
use App\Models\StorePartnerProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


class CartController extends Controller
{
 public function index()
{
    $user = Auth::user();

    if ($user->role == 'super_admin') {
        // سوپر ادمین همه محصولات را می‌بیند
        $carts = Cart::with(['product', 'user'])->get();
    } else {
        $storeId = $user->store_id;

        // گرفتن روابط فعال همکاری (store_partner_id ها)
        $storePartnerIds = StorePartner::where(function ($query) use ($storeId) {
                $query->where('store_id', $storeId)
                      ->orWhere('partner_store_id', $storeId);
            })
            ->where('status', 1)
            ->pluck('id')
            ->toArray();

        // گرفتن ID محصولات اشتراکی از جدول partner_products
        $sharedProductIds = StorePartnerProduct::whereIn('store_partner_id', $storePartnerIds)
            ->pluck('product_id')
            ->unique()
            ->toArray();

        // گرفتن محصولات فروشگاه خودش و محصولات اشتراکی
        $carts = Cart::with(['product', 'user'])
            ->whereHas('product', function (Builder $query) use ($storeId, $sharedProductIds) {
                $query->where('store_id', $storeId)
                      ->orWhereIn('id', $sharedProductIds);
            })
            ->get();
    }

    return view('Admin.Cart.index', compact('carts'));
}
    public function destroy($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->route('panel.cart.index')->with('success', 'سبد خرید با موفقیت حذف شد');
    }
 public function show($id)
{
    $currentUser = Auth::user();

    if ($currentUser->role == 'super_admin') {
        $cart = Cart::with(['product.store', 'user'])->find($id);
    } else {
        $storeId = $currentUser->store_id;

        $partnerStoreIds = StorePartner::where('store_id', $storeId)
            ->where('status', 1)
            ->pluck('partner_store_id')
            ->toArray();

        $partnerStoreIds = array_merge($partnerStoreIds,
            StorePartner::where('partner_store_id', $storeId)
                ->where('status', 1)
                ->pluck('store_id')
                ->toArray());

        $allowedStoreIds = array_merge([$storeId], $partnerStoreIds);

        $cart = Cart::where('id', $id)
            ->whereHas('product', function ($query) use ($allowedStoreIds) {
                $query->whereIn('store_id', $allowedStoreIds);
            })
            ->with(['product.store', 'user'])
            ->first();
    }

    if (!$cart) {
        abort(404, 'سبد خرید مورد نظر یافت نشد.');
    }

    // چک می‌کنیم محصول در محصولات اشتراکی است یا خیر
    $partnerStoreName = null;

    $storePartnerProduct = StorePartnerProduct::where('product_id', $cart->product->id)->first();

    if ($storePartnerProduct) {
        // گرفتن آی‌دی همکاری
        $storePartnerId = $storePartnerProduct->store_partner_id;

        // گرفتن مدل StorePartner برای دسترسی به فروشگاه‌ها
        $storePartner = StorePartner::find($storePartnerId);

        if ($storePartner) {
            // فروشگاه شریک
            // چک کنید اگر فروشگاه اصلی فروشگاه شما است، پس فروشگاه شریک را نمایش دهید و بالعکس
            if ($storePartner->store_id == $cart->product->store_id) {
                // فروشگاه اصلی، پس فروشگاه شریک نمایش داده شود
                $partnerStoreId = $storePartner->partner_store_id;
            } else {
                $partnerStoreId = $storePartner->store_id;
            }

            // حالا نام فروشگاه شریک را بگیریم
            $partnerStore = \App\Models\Store::find($partnerStoreId);
            if ($partnerStore) {
                $partnerStoreName = $partnerStore->name;
            }
        }
    }

    $store = $cart->product->store;
    $user = $cart->user; // اطلاعات کاربر

    return view('Admin.Cart.show', compact('cart', 'store', 'partnerStoreName', 'user'));
}


}
