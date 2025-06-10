<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class ReportController extends Controller
{


    public function index()
    {
        $user = Auth::user();
        return view('Admin.Report.index');
    }

    public function storeReport(Request $request)
    {
        $user = Auth::user();
        $query = Order::query();

        // فقط سفارش‌هایی که status = 1 دارند
        $query->where('status', 1);

        // نمایش سفارش‌های مربوط به فروشگاه ادمین
        if ($user->role === 'admin') {
            $query->whereHas('orderItems', function ($q) use ($user) {
                $q->where(function ($subQ) use ($user) {
                    $subQ->where('seller_store_id', $user->store_id)
                         ->orWhere('owner_store_id', $user->store_id);
                });
            });
        }

        // فیلتر تاریخ با تبدیل شمسی به میلادی
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                $start = Jalalian::fromFormat('Y/m/d', $request->start_date)->toCarbon()->startOfDay();
                $end = Jalalian::fromFormat('Y/m/d', $request->end_date)->toCarbon()->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            } catch (\Exception $e) {

                return back()->with('error', 'فرمت تاریخ وارد شده نامعتبر است.');
            }
        }

        // فیلتر بر اساس کد سفارش
        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }

        // دریافت سفارش‌ها و آیتم‌های مرتبط با محصول
        $orders = $query->with(['orderItems' => function ($q) use ($user) {
            $q->with(['product', 'sellerStore', 'ownerStore']);
            if ($user->role === 'admin') {
                $q->where(function ($subQ) use ($user) {
                    $subQ->where('seller_store_id', $user->store_id)
                         ->orWhere('owner_store_id', $user->store_id);
                });
            }
        }])->get();

        // فیلتر و شمارش محصولات فروخته‌شده
        $productsQuery = Product::query();

        if ($user->role === 'admin') {
            $productsQuery->where('store_id', $user->store_id);
        }

        // فیلتر بر اساس نام محصول
        if ($request->filled('product_name')) {
            $productsQuery->where('name', 'like', '%' . $request->product_name . '%');
        }

        $products = $productsQuery->withCount(['orderItems as sold_quantity' => function ($q) use ($request) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                try {
                    $start = Jalalian::fromFormat('Y/m/d', $request->start_date)->toCarbon()->startOfDay();
                    $end = Jalalian::fromFormat('Y/m/d', $request->end_date)->toCarbon()->endOfDay();
                    $q->whereHas('orderItems', function ($orderQuery) use ($start, $end) {
                        $orderQuery->whereBetween('created_at', [$start, $end])
                                   ->where('status', 1);
                    });
                } catch (\Exception $e) {
                    // در صورت مشکل تاریخ، فیلتر اعمال نمی‌شود
                }
            }
        }])->get();

        return view('Admin.Report.store', compact('orders', 'products', 'user'));
    }

    public function show($id)
    {
        $user = auth()->user();

        // بارگذاری سفارش به همراه آیتم‌ها، محصول‌ها، فروشگاه‌ها (صاحب و فروشنده)
        $order = Order::with([
            'orderItems.product',
            'orderItems.ownerStore',
            'orderItems.sellerStore',
        ])->findOrFail($id);

        // اگر نقش ادمین است، بهتر است بررسی کنید که سفارش مربوط به فروشگاهش باشد
        if ($user->role == 'admin') {
            $hasAccess = $order->orderItems->contains(function($item) use($user) {
                return $item->owner_store_id == $user->store_id || $item->seller_store_id == $user->store_id;
            });
            if (!$hasAccess) {
                abort(403, 'شما دسترسی به این سفارش ندارید.');
            }
        }

        return view('Admin.Report.show', compact('order', 'user'));
    }
}
