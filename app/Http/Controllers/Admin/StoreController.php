<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'super_admin') {

            $stores = Store::all();

        } else
        {

            $storeId = $user->store_id;
            $stores = Store::where('id', $storeId)->get();

        }

        return view('Admin.Store.index', compact('stores', 'user'));
    }
    public function create(Request $request)
    {
        $user = Auth::user();

        // بررسی اگر کاربر قبلاً مغازه داشته باشد
        if ($user->store_id) {
            // ارسال ایمیل
            Mail::raw('شما قبلاً یک مغازه ثبت کرده‌اید و نمی‌توانید مجدداً ثبت کنید.', function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('درخواست مغازه تکراری');
            });

            return redirect()->back()->with('error', 'شما قبلاً یک مغازه ثبت کرده‌اید.');
        }

        // اعتبارسنجی داده‌های ورودی
$request->validate([
    'name' => 'required|string|max:255',
    'address' => 'required|string|max:255',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    'phone_number' => ['required', 'regex:/^09\d{9}$/'], // شماره موبایل ایرانی
    'productTypes' => 'required|string|min:5',
], [
    // پیام‌های سفارشی خطاها
    'name.required' => 'لطفاً نام فروشگاه را وارد کنید.',
    'address.required' => 'لطفاً آدرس فروشگاه را وارد کنید.',
    'image.required' => 'لطفاً تصویر فروشگاه را انتخاب کنید.',
    'phone_number.required' => 'لطفاً شماره تماس را وارد کنید.',
    'phone_number.regex' => 'شماره موبایل باید با 09 شروع شده و 11 رقم باشد.',
    'productTypes.required' => 'لطفاً توضیحات محصولات را وارد کنید.',
    'productTypes.min' => 'توضیحات باید حداقل 5 کاراکتر باشد.',
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
        $user->update([
            'store_id' => $store->id,
        ]);

        return redirect()->route('home')->with('message', 'درخواست ثبت مغازه ارسال شد. منتظر تأیید مدیر باشید.');
    }


    public function approve(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $store->update([
            'is_approved' => true,
            'status' => '1',
            'approved_at' => now(),
            'rejected_at' => null, // در صورت تایید مجدد پس از رد
        ]);

        $user = $store->admin;
        if ($user) {
            $user->update([
                'role' => 'admin',
            ]);
        }

        \Mail::raw('مغازه ' . $store->name . ' با موفقیت تایید شد.', function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('مغازه تایید شد');
        });

        return redirect()->back()->with('success', 'مغازه با موفقیت تایید شد و نقش کاربر به مدیر تغییر یافت.');
    }

    public function reject(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $store->update([
            'is_approved' => false,
            'status' => 0,
            'rejected_at' => now(),
            'approved_at' => null, // در صورت رد مجدد پس از تایید
        ]);

        \Mail::raw('مغازه ' . $store->name . ' توسط مدیریت رد شده است.', function ($message) use ($store) {
            $message->to($store->admin->email)
                    ->subject('رد درخواست مغازه');
        });

        return redirect()->back()->with('success', 'مغازه با موفقیت رد شد.');
    }


    public function edit($id)
    {
        $store = Store::find($id);

        return view("Admin.Store.edit", compact('store'));
    }

    public function update(Request $request, $id)
    {
        $store = Store::find($id);


        $dataForm = $request->except('image');


        if ($request->hasFile('image')) {
            $imageName = time() . "." . $request->image->extension();
            $request->image->move(public_path("AdminAssets/Store-image"), $imageName);
            $dataForm['image'] = $imageName;


            $picture = public_path("AdminAssets/Store-image/") . $store->image;
            if (File::exists($picture)) {
                File::delete($picture);
            }
        }

        $store->update($dataForm);


        return redirect()->route('store.index')->with('success', 'مغازه با موفقیت ویرایش شد');
    }

    public function show($id)
    {
        $currentUser = Auth::user();

        if ($currentUser->role == 'super_admin') {

            $store = Store::find($id);


            return view('Admin.Store.show', compact('store'));
        }

        $store = $currentUser->store;

        return view('Admin.Store.show', compact('store'));
    }
    public function destroy($id)
    {
        $store = Store::findOrFail($id);

        // ابتدا همه کاربران مرتبط با این مغازه را به‌روزرسانی می‌کنیم
        $users = User::where('store_id', $store->id)->get();
        foreach ($users as $user) {
            $user->update([
                'store_id' => null,
                'role' => 'user'
            ]);
        }

        // حذف تصویر قبلی اگر وجود داشت
        $picture = public_path("AdminAssets/Store-image/") . $store->image;
        if (File::exists($picture)) {
            File::delete($picture);
        }

        // حذف مغازه
        $store->delete();

        // نمایش پیام موفقیت
        return redirect()->route("store.index")->with('success', 'مغازه و دسترسی‌های مرتبط با موفقیت حذف شدند');
    }
    public function filter(Request $request)
    {
        $user = Auth::user();
        $query = Store::query();

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




        $stores = $query->latest()->paginate(10);

        return view('Admin.Store.index', [
            'stores' => $stores,
            'search' => $request->search,
            'status' => $request->status,
            'user' => $user
        ]);
    }
}
