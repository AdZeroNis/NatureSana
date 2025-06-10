<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Order;
use App\Models\StorePartner;
use Illuminate\Http\Request;
use App\Models\StorePartnerProduct;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
class OrderController extends Controller
{
public function index()
{
    $user = Auth::user();

    if ($user->role == 'super_admin') {
        // سوپر ادمین همه سفارش‌ها را با محصولاتشان می‌بیند
        $orders = Order::with('orderItems.product.store')->get();
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

        // گرفتن سفارشاتی که حداقل یکی از محصولاتشان متعلق به فروشگاه خودشان یا محصولات اشتراکی است
        $orders = Order::whereHas('orderItems.product', function (Builder $query) use ($storeId, $sharedProductIds) {
                $query->where('store_id', $storeId)
                      ->orWhereIn('id', $sharedProductIds);
            })
            ->with('orderItems.product.store')
            ->get();
    }

    // بررسی مجوز ویرایش برای هر سفارش
    $orders = $orders->map(function ($order) use ($user) {
        $currentStoreId = $user->store_id ?? null;

        $isCollaborative = $order->orderItems->contains(function ($item) {
            return $item->owner_store_id !== $item->seller_store_id;
        });

        $ownerStoreId = optional($order->orderItems->first())->owner_store_id;

        // افزودن متغیر can_edit به هر سفارش
        $order->can_edit = !$isCollaborative || $ownerStoreId == $currentStoreId || $user->role == 'super_admin';

        return $order;
    });

    return view('Admin.Order.index', compact('orders'));
}

public function updateStatus(Request $request, Order $order)
{
    $user = Auth::user();
    $currentStoreId = $user->store_id ?? null;

    $isCollaborative = $order->orderItems->contains(function ($item) {
        return $item->owner_store_id !== $item->seller_store_id;
    });

    $ownerStoreId = optional($order->orderItems->first())->owner_store_id;
    $canEdit = !$isCollaborative || $ownerStoreId == $currentStoreId || $user->role == 'super_admin';

    if (!$canEdit) {
        return back()->with('error', 'شما اجازه تغییر وضعیت این سفارش را ندارید.');
    }

    $validated = $request->validate([
        'status' => 'required|in:0,1,2',
    ]);

    $newStatus = (int)$validated['status'];
    $oldStatus = $order->status;

    // اگر وضعیت تغییر کرده
    if ($oldStatus !== $newStatus) {
        if ($newStatus == 2) {
            // وقتی وضعیت به "عدم ارسال" تغییر کرد، موجودی محصولات را افزایش بده
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                $product->inventory += $item->quantity;
                $product->save();
            }
        } elseif ($oldStatus == 2 && in_array($newStatus, [0, 1])) {
            // اگر قبلاً وضعیت 2 بوده و الان به 0 یا 1 تغییر کرده، موجودی را دوباره کاهش بده
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                // اطمینان از اینکه موجودی منفی نشود
                $product->inventory = max(0, $product->inventory - $item->quantity);
                $product->save();
            }
        }
    }

    $order->status = $newStatus;
    $order->save();

    return back()->with('success', 'وضعیت سفارش با موفقیت به‌روزرسانی شد.');
}

 public function destroy($id){
    $order=Order::find($id);

     $order->delete();

     return redirect()->route("panel.order.index")->with('success', 'سفارش با موفقیت حذف شد');;
}
public function show($id)
{
  $order = Order::with(['user', 'orderItems.product', 'orderItems.sellerStore'])->findOrFail($id);

    $totalOwnerShare = $order->orderItems->sum(function($item) {
        return $item->owner_share * $item->quantity;
    });

   $totalSellerShare = $order->orderItems->sum(function($item) {
        return $item->seller_share * $item->quantity;
    });

    return view('Admin.Order.show', compact('order', 'totalOwnerShare','totalSellerShare'));
}
}

