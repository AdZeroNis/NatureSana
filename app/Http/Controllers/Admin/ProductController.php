<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\StorePartner;
use Illuminate\Http\Request;
use App\Models\StorePartnerProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
public function index()
{
    $user = Auth::user();

    if ($user->role == 'super_admin') {
        // سوپر ادمین همه محصولات را می‌بیند
        $products = Product::all();
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

        // گرفتن محصولات فروشگاه خودش
        $ownProducts = Product::where('store_id', $storeId)->get();

        // گرفتن محصولات اشتراکی
        $sharedProducts = Product::whereIn('id', $sharedProductIds)->get();

        // ترکیب دو لیست
        $products = $ownProducts->merge($sharedProducts);
    }

    return view('Admin.Product.index', compact('products'));
}


   public function create()
   {
    $user = Auth::user();
    $stores = [];

    if ($user->role == 'super_admin') {
        $stores = \App\Models\Store::all();
        $categories = Category::all();
    } else {
        $categories = Category::where('store_id', $user->store_id)->get();
    }

    return view('Admin.Product.create', compact('categories', 'stores'));
   }

   public function store(Request $request)
   {
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required',
        'inventory' => 'required',
        'price' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $data = $request->all();
    if (Auth::user()->role != 'super_admin') {
        $data['store_id'] = Auth::user()->store_id;
    }

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('AdminAssets/Product-image'), $filename);
        $data['image'] = $filename;
    }
    $exists = Product::where('name', $data['name'])
            ->where('store_id', $data['store_id'] ?? null)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'این محصول قبلاً ثبت شده است.');
        }

    Product::create($data);

    return redirect()->route('panel.product.index')
        ->with('success', 'محصول با موفقیت اضافه شد');
}
public function getByStore($store_id)
{
    $categories = Category::where('store_id', $store_id)->get();
    return response()->json($categories);
}
   public function edit($id)
   {
    $product = Product::find($id);
    $user = Auth::user();
    $stores = [];

    if ($user->role == 'super_admin') {
        $stores = \App\Models\Store::all();
        $categories = Category::all();
    } else {
        $categories = Category::where('store_id', $user->store_id)->get();
    }

    return view('Admin.Product.edit', compact('product', 'categories', 'stores'));
   }

   public function update(Request $request, $id)
   {
    $product = Product::find($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required',
        'inventory' => 'required',
        'price' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $dataForm = $request->except('image');

    if (Auth::user()->role != 'super_admin') {
        $dataForm['store_id'] = Auth::user()->store_id;
    }

    if ($request->hasFile('image')) {
        $imageName = time() . "." . $request->image->extension();
        $request->image->move(public_path("AdminAssets/Product-image"), $imageName);
        $dataForm['image'] = $imageName;

        $picture = public_path("AdminAssets/Product-image/") . $product->image;
        if (File::exists($picture)) {
            File::delete($picture);
        }
    }

    $product->update($dataForm);

    return redirect()->route('panel.product.index')
        ->with('success', 'محصول با موفقیت ویرایش شد');
   }

   public function destroy($id){
    $product=Product::find($id);
       // حذف تصویر قبلی اگر وجود داشت
       $picture = public_path("AdminAssets\Product-image/") . $product->image;
       if(File::exists($picture)){
           File::delete($picture);
       }
     $product->delete();

     return redirect()->route("panel.product.index")->with('success', 'محصول با موفقیت حذف شد');;
}

public function show($id)
{
    $currentUser = Auth::user();

    if ($currentUser->role == 'super_admin') {
        $product = Product::find($id);
    } else {
        $storeId = $currentUser->store_id;

        // گرفتن آیدی فروشگاه‌های شریک
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

        // حالا فقط محصولاتی که در این فروشگاه‌ها هستند را جستجو کنید
        $product = Product::whereIn('store_id', $allowedStoreIds)->find($id);
    }

    if (!$product) {
        abort(404, 'محصول مورد نظر یافت نشد.');
    }

    $store = $product->store;

    return view('Admin.Product.show', compact('product', 'store'));
}


  public function filter(Request $request)
{
    $query = Product::query();

    $user = Auth::user();

    if ($user->role != 'super_admin') {
        $storeId = $user->store_id;
        $partnerIds = $user->store->partners()->pluck('partner_id')->toArray();
        $query->whereIn('store_id', array_merge([$storeId], $partnerIds));
    }

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('status')) {
        if ($request->status === 'active') {
            $query->where('status', 1);
        } elseif ($request->status === 'inactive') {
            $query->where('status', 0);
        }
    }

    $products = $query->latest()->paginate(10);

    return view('Admin.Product.index', [
        'products' => $products,
        'search' => $request->search,
        'status' => $request->status,
    ]);
}

}
