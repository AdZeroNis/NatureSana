<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
   public function index()
   {
    $storeId = Auth::user()->store_id;
    
    if (Auth::user()->role == 'super_admin') {
        $products = Product::all();
    } else {
        $products = Product::where('store_id', $storeId)->get();
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
        $product = Product::where('store_id', $currentUser->store_id)->find($id);
    }
    $store = $product->store;

    return view('Admin.Product.show', compact('product', 'store'));
   }

   public function filter(Request $request)
   {
    $query = Product::query();
    
    // جستجو بر اساس نام
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // فیلتر بر اساس وضعیت فعال/غیرفعال
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
