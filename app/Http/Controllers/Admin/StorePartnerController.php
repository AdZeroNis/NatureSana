<?php

namespace App\Http\Controllers\Admin;
use App\Models\Store;
use App\Models\Product;
use App\Models\StorePartner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorePartnerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // اگر سوپر ادمین بود، همه همکاری‌ها را نمایش بده
        if ($user->role === 'super_admin') {
            $partners = StorePartner::with(['store', 'partnerStore'])->get();
        } else {
            // در غیر این صورت فقط همکاری‌های مربوط به فروشگاه کاربر
            $storeId = $user->store_id;

            $partners = StorePartner::with(['store', 'partnerStore'])
                ->where('store_id', $storeId)
                ->orWhere('partner_store_id', $storeId)
                ->get();
        }

        // Get products for each partnership
        $partnerProducts = [];
        foreach ($partners as $partner) {
            $store = $partner->store;
            $partnerStore = $partner->partnerStore;
            if ($store && $partnerStore) {
                // Get product names from both stores
                $storeProductNames = $store->products()->pluck('name')->toArray();
                $partnerProductNames = $partnerStore->products()->pluck('name')->toArray();

                // Get unique product names (filter out products with same names)
             $allPartnerProducts = $partnerStore->products()->get();
$partnerProducts[$partner->id] = $allPartnerProducts;

            }
        }

        return view('Admin.Partner.index', compact('partners', 'partnerProducts'));
    }

    public function create()
{
    $stores = Store::all();
    return view('Admin.Partner.create', compact('stores'));
}
public function store(Request $request)
{
    $request->validate([
        'partner_store_id' => 'required|exists:stores,id',
        'store_id' => Auth::user()->role === 'super_admin' ? 'required|exists:stores,id' : '',
    ]);

    $storeId = Auth::user()->role === 'super_admin' ? $request->store_id : Auth::user()->store_id;

    // جلوگیری از همکاری یک فروشگاه با خودش
    if ($storeId == $request->partner_store_id) {
        return back()->withErrors(['partner_store_id' => 'فروشگاه نمی‌تواند با خودش همکاری کند.'])->withInput();
    }

    // جلوگیری از تکراری بودن همکاری
    $exists = StorePartner::where('store_id', $storeId)
        ->where('partner_store_id', $request->partner_store_id)
        ->exists();

    if ($exists) {
        return back()->withErrors(['partner_store_id' => 'این همکاری قبلاً ثبت شده است.'])->withInput();
    }

    // ایجاد همکاری با وضعیت 0 (درخواست در انتظار تایید)
    StorePartner::create([
        'store_id' => $storeId,
        'partner_store_id' => $request->partner_store_id,
        'status' => 0,  // درخواست در انتظار تایید
        'created_by_admin' => Auth::user()->role === 'super_admin',
    ]);

    return redirect()->route('panel.partner.index')->with('success', 'درخواست همکاری ارسال شد. منتظر تایید فروشگاه اصلی باشید.');
}

public function update(Request $request, $id)
{
    $partner = StorePartner::findOrFail($id);
    $user = Auth::user();

    $isMainStore = $partner->store_id === $user->store_id;
    $isPartnerStore = $partner->partner_store_id === $user->store_id;

    if (!($isMainStore || $isPartnerStore)) {
        return redirect()->back()->withErrors(['error' => 'شما اجازه تایید یا رد این درخواست را ندارید.']);
    }

    $status = $request->input('status'); // تغییر به input برای اطمینان

    if ($isMainStore) {
        $partner->store_approval = $status;
    }

    if ($isPartnerStore) {
        $partner->partner_approval = $status;
    }

    // منطق به‌روزرسانی وضعیت کلی
    if ($partner->store_approval == 1 && $partner->partner_approval == 1) {
        $partner->status = 1; // تایید شده
    } elseif ($partner->store_approval == 2 || $partner->partner_approval == 2) {
        $partner->status = 2; // رد شده
    } else {
        $partner->status = 0; // در انتظار تایید
    }

    $partner->save();

    return redirect()->route('panel.partner.index')->with('success', 'وضعیت همکاری به‌روز شد.');
}



public function show($id)
{
    $partner = StorePartner::with(['store', 'partnerStore'])->findOrFail($id);
    $user = Auth::user();

    // تعیین اینکه کاربر مالک کدام فروشگاه است
    $isMainStore = $user->store_id === $partner->store_id;
    $isPartnerStore = $user->store_id === $partner->partner_store_id;

    // اگر سوپر ادمین نیست و به این همکاری دسترسی ندارد
    if ($user->role !== 'super_admin' && !$isMainStore && !$isPartnerStore) {
        abort(403, 'دسترسی غیرمجاز');
    }

    // برای سوپر ادمین هر دو فروشگاه را نمایش بده
    if ($user->role === 'super_admin') {
        $mainStoreProducts = $partner->store->products;
        $partnerStoreProducts = $partner->partnerStore->products;

        return view('Admin.Partner.show', [
            'partner' => $partner,
            'mainStoreProducts' => $mainStoreProducts,
            'partnerStoreProducts' => $partnerStoreProducts,
            'sharedProducts' => $partner->sharedProducts()->pluck('products.id')->toArray(),
            'isMainStore' => false,
            'isPartnerStore' => false,
            'isSuperAdmin' => true,
        ]);
    }

   if ($isPartnerStore) {
    // همکار می‌تواند محصولات فروشگاه اصلی را ببیند و انتخاب کند
    $productsToShow = $partner->store->products;
} else {
    // فروشگاه اصلی فقط محصولات خودش را می‌بیند و نمی‌تواند محصولی از همکار انتخاب کند
    $productsToShow = $partner->store->products; // فقط محصولات خودش را نمایش بده
}


    return view('Admin.Partner.show', [
        'partner' => $partner,
        'productsToShow' => $productsToShow,
        'sharedProducts' => $partner->sharedProducts()->pluck('products.id')->toArray(),
        'isMainStore' => $isMainStore,
        'isPartnerStore' => $isPartnerStore,
        'isSuperAdmin' => false,
    ]);
}

public function storePartnerProducts(Request $request, $partnerId)
{
    $partner = StorePartner::findOrFail($partnerId);
    $user = Auth::user();

    // فقط مالک فروشگاه اصلی یا همکار یا سوپر ادمین می‌تواند ادامه دهد
    if (($user->store_id !== $partner->store_id &&
         $user->store_id !== $partner->partner_store_id) &&
        $user->role !== 'super_admin') {
        return back()->withErrors(['error' => 'دسترسی غیرمجاز']);
    }

    $validated = $request->validate([
        'product_ids' => 'nullable|array',
        'product_ids.*' => 'exists:products,id'
    ]);

    $productIds = $validated['product_ids'] ?? [];

    $partner->sharedProducts()->syncWithoutDetaching($productIds);


    return redirect()->route('panel.partner.show', $partnerId)
        ->with('success', 'تغییرات محصولات با موفقیت ذخیره شدند.');
}


    public function destroy(StorePartner $partner)
    {
        $user = Auth::user();

        // Check if user has permission to delete this partnership
        if ($user->role === 'super_admin' ||
            $user->store_id === $partner->store_id ||
            $user->store_id === $partner->partner_store_id) {

            $partner->delete();
            return redirect()->route('panel.partner.index')
                ->with('success', 'همکاری با موفقیت حذف شد.');
        }

        return redirect()->route('panel.partner.index')
            ->with('error', 'شما اجازه حذف این همکاری را ندارید.');
    }
}
