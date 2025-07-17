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
    $productQuery = Product::query();

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

        $productQuery->where('store_id', $user->store_id);
    }

    // فیلترهای سوپر ادمین
    if ($user->role === 'super_admin') {
        // فیلتر بر اساس مغازه
        if ($request->filled('store_id')) {
            $storeId = $request->store_id;

            $query->whereHas('orderItems', function ($q) use ($storeId) {
                $q->where('seller_store_id', $storeId)
                  ->orWhere('owner_store_id', $storeId);
            });

            $productQuery->where('store_id', $storeId);
        }

        // فیلتر بر اساس دسته بندی
        if ($request->filled('category_id')) {
            $productQuery->where('category_id', $request->category_id);

            $query->whereHas('orderItems.product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // فیلتر بر اساس محصول خاص
        if ($request->filled('product_id')) {
            $productQuery->where('id', $request->product_id);

            $query->whereHas('orderItems', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }
    }

    // فیلتر تاریخ با تبدیل شمسی به میلادی
    if ($request->filled('start_date') && $request->filled('end_date')) {
        try {
            $start = Jalalian::fromFormat('Y/m/d', $request->start_date)->toCarbon()->startOfDay();
            $end = Jalalian::fromFormat('Y/m/d', $request->end_date)->toCarbon()->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
            $productQuery->whereBetween('created_at', [$start, $end]);
        } catch (\Exception $e) {
            return back()->with('error', 'فرمت تاریخ وارد شده نامعتبر است.');
        }
    }

    // فیلتر بر اساس کد سفارش
    if ($request->filled('order_id')) {
        $query->where('id', $request->order_id);
    }

    // فیلتر بر اساس نام محصول
    if ($request->filled('product_name')) {
        $productQuery->where('name', 'like', '%' . $request->product_name . '%');
    }

    // دریافت داده‌ها
    $orders = $query->with(['orderItems' => function ($q) use ($user) {
        $q->with(['product', 'sellerStore', 'ownerStore']);
        if ($user->role === 'admin') {
            $q->where(function ($subQ) use ($user) {
                $subQ->where('seller_store_id', $user->store_id)
                     ->orWhere('owner_store_id', $user->store_id);
            });
        }
    }])->get();

    // محاسبه تعداد فروخته شده با فیلتر تاریخ
    $products = $productQuery->with(['store', 'category'])
        ->withCount(['orderItems as sold_quantity' => function ($q) use ($request) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                try {
                    $start = Jalalian::fromFormat('Y/m/d', $request->start_date)->toCarbon()->startOfDay();
                    $end = Jalalian::fromFormat('Y/m/d', $request->end_date)->toCarbon()->endOfDay();
                    $q->whereHas('order', function ($orderQuery) use ($start, $end) {
                        $orderQuery->whereBetween('created_at', [$start, $end])
                                   ->where('status', 1);
                    });
                } catch (\Exception $e) {}
            }
        }])->get();

    // داده‌های لازم برای سوپر ادمین
    $stores = $user->role === 'super_admin' ? Store::all() : collect();
    $categories = $user->role === 'super_admin' && $request->filled('store_id')
        ? Category::where('store_id', $request->store_id)->get()
        : collect();
    $categoryProducts = $user->role === 'super_admin' && $request->filled('category_id')
        ? Product::where('category_id', $request->category_id)->get()
        : collect();

    return view('Admin.Report.store', compact(
        'orders',
        'products',
        'user',
        'stores',
        'categories',
        'categoryProducts'
    ));
}
public function getCategoriesByStore($store_id)
{
    $categories = Category::where('store_id', $store_id)->get();
    return response()->json($categories);
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
    public function getByCategory($category_id)
{
    $products = \App\Models\Product::where('category_id', $category_id)->get();
    return response()->json($products);
}

}
