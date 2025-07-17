<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
  public function index()
{
    $user = Auth::user();

    if ($user->role == 'super_admin') {
        // سوپر ادمین همه سفارش‌ها را با محصولاتشان می‌بیند
        $orders = Order::with('orderItems.product.store')
                       ->orderBy('created_at', 'desc')
                       ->get();
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
            ->orderBy('created_at', 'desc')
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

    public function create()
    {
        $user = Auth::user();
        $stores = [];

        if ($user->role == 'super_admin') {
            $stores = Store::all();
        }

        return view('Admin.Category.create', compact('stores'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $user = Auth::user();

        // تعیین فروشگاه
        if ($user->role != 'super_admin') {
            $data['store_id'] = $user->store_id;
        }

        // بررسی تکراری بودن دسته بندی در فروشگاه
        $exists = Category::where('name', $data['name'])
            ->where('store_id', $data['store_id'] ?? null)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'این دسته‌بندی قبلاً برای این فروشگاه ثبت شده است.');
        }

        Category::create($data);

        return redirect()->route('panel.category.index')
            ->with('success', 'دسته‌بندی با موفقیت اضافه شد');
    }



  public function edit($id)
  {
        $category=Category::find($id);
        return view("Admin.Category.edit",compact("category"));
}
public function update(Request $request, $id) {
    $category = Category::find($id);
    $dataForm=$request->all();


    $category->update($dataForm);


    return redirect()->route("panel.category.index")->with('success', 'دسته بندی با موفقیت ویرایش شد');
}


    public function destroy($id){
        $category=Category::find($id);
        // if ($category->products()->exists()) {

        //     Alert::error('خطا', 'این دسته بندی دارای  محصول  است و نمی‌توان آن را حذف کرد.');
        //     return redirect()->route('panel.category.index')
        // }
         $category->delete();
         return redirect()->route('panel.category.index')
         ->with('success', 'دسته‌بندی با موفقیت حذف شد');
    }
    public function filter(Request $request)
    {
        $user = Auth::user();

        $query = Category::query();

        // فقط دسته‌بندی‌های مرتبط با فروشگاه خودش (مگر اینکه سوپر ادمین باشد)
        if ($user->role != 'super_admin') {
            $query->where('store_id', $user->store_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
        }

        $categories = $query->get();

        return view('Admin.Category.index', [
            'categories' => $categories,
            'search' => $request->search,
            'status' => $request->status
        ]);
    }

}
