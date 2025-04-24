<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::query();

        // جستجو بر اساس نام
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // فیلتر بر اساس وضعیت
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->whereNull('is_approved');
            } elseif ($request->status === 'active') {
                $query->where('status', '1');
            } elseif ($request->status === 'inactive') {
                $query->where('status', '0');
            }
        }

        $stores = $query->latest()->paginate(10);
        return view('Admin.Store.index', compact('stores'));
    }
    public function create(Request $request)
{
    // اعتبارسنجی داده‌های ورودی
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'phone_number' => 'required|string|max:20',
    ]);

    // آپلود تصویر
    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('AdminAssets/Store-image'), $imageName);

    // ایجاد مغازه با status = 0 (در انتظار تأیید)
    $store = Store::create([
        'name' => $request->input('name'),
        'address' => $request->input('address'),
        'image' => $imageName,
        'phone_number' => $request->input('phone_number'),
        'admin_id' => Auth::id(),
        'status' => 0,
    ]);
    // آپدیت store_id کاربر

    $user = Auth::user();

    $user->update([
        'store_id' => $store->id,
       
    ]);

    return redirect()->route('home')->with('message', 'درخواست ثبت مغازه ارسال شد. منتظر تأیید مدیر باشید.');

}

public function approve(Request $request, $id)
{
    $store = Store::findOrFail($id);

    // تایید مغازه
    $store->update([
        'is_approved' => true,
        'status' => '1',
    ]);

    // تغییر نقش کاربر به admin
    $user = $store->admin;
    if ($user) {
        $user->update([
            'role' => 'admin',
        ]);
    }

    return redirect()->back()->with('success', 'مغازه با موفقیت تایید شد و نقش کاربر به مدیر تغییر یافت.');
}


    public function reject(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
    
        return redirect()->back()->with('success', 'مغازه با موفقیت حذف شد.');
    }
    

    public function getUserStore()
    {
        return Store::where('admin_id', Auth::id())->first();
    }
}

