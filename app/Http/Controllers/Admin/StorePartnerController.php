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
                $uniqueProducts = $partnerStore->products()
                    ->whereNotIn('name', $storeProductNames)
                    ->get();
                
                $partnerProducts[$partner->id] = $uniqueProducts;
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

    // جلوگیری از تکراری بودن همکاری
    $exists = \App\Models\StorePartner::where('store_id', $storeId)
        ->where('partner_store_id', $request->partner_store_id)
        ->exists();

    if ($exists) {
        return back()->withErrors(['partner_store_id' => 'این همکاری قبلاً ثبت شده است.'])->withInput();
    }

    // ایجاد همکاری با وضعیت 0 (درخواست در انتظار تایید)
    \App\Models\StorePartner::create([
        'store_id' => $storeId,
        'partner_store_id' => $request->partner_store_id,
        'status' => 0,  // درخواست در انتظار تایید
        'created_by_admin' => Auth::user()->role === 'super_admin',  // آیا توسط سوپر ادمین ایجاد شده
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
    
    // Get products from both stores
    $storeProducts = $partner->store->products;
    $partnerProducts = $partner->partnerStore->products;
    
    // Get product names from both stores for filtering
    $storeProductNames = $storeProducts->pluck('name')->toArray();
    $partnerProductNames = $partnerProducts->pluck('name')->toArray();
    
    // Filter out products with same names
    $uniquePartnerProducts = $partnerProducts->whereNotIn('name', $storeProductNames);
    $uniqueStoreProducts = $storeProducts->whereNotIn('name', $partnerProductNames);
    
    return view('Admin.Partner.show', [
        'partner' => $partner,  // Single partnership record
        'uniqueStoreProducts' => $uniqueStoreProducts,
        'uniquePartnerProducts' => $uniquePartnerProducts,
        'store' => $partner->store,
        'partnerStore' => $partner->partnerStore
    ]);
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
