<?php

namespace App\Http\Controllers\Home;

use App\Models\Store;
use App\Models\Slider;
use App\Models\Article;
use App\Models\Product;
use App\Models\Category;
use App\Models\StorePartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StorePartnerProduct;

class HomeController extends Controller
{
    public function home() {
        $latestItems = [
            'products' => Product::where('status', 1)
                                  ->orderBy('created_at', 'desc')
                                  ->take(10)
                                  ->get(),

            'stores' => Store::where('status', 1)
                              ->take(5)
                              ->get(),

            'sliders' => Slider::orderBy('created_at', 'desc')
                                ->take(3)
                                ->get(),
        ];

        return view('Home.index', compact('latestItems'));
    }

    public function showProduct($id)
    {
        $product = Product::find($id);
        return view('Home.product_single', compact('product'));
    }
    public function articles() {
        $latestArticles = Article::where('status', 1)
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();

        return view('Home.articles_list', compact('latestArticles'));
    }

    public function showArticle($id)
    {
        $article = Article::find($id);
        return view('Home.article_single', compact('article'));
    }

 public function showStoreProducts($id)
{
    $store = Store::with(['products' => function($query) {
        $query->where('status', 1);
    }])->findOrFail($id);

    // محصولات خود فروشگاه
    $products = $store->products;
    $productNames = $products->pluck('name')->toArray();

    // گرفتن همه partnerها که این فروشگاه در آن‌ها دخیل است
    $partners = StorePartner::where(function ($query) use ($store) {
        $query->where('store_id', $store->id)
              ->orWhere('partner_store_id', $store->id);
    })->pluck('id');

    // گرفتن آی‌دی محصولات انتخاب‌شده برای همکاری
    $selectedProductIds = StorePartnerProduct::whereIn('store_partner_id', $partners)
        ->pluck('product_id')
        ->unique()
        ->toArray();

    // گرفتن محصولاتی از فروشگاه‌های دیگر که در همکاری انتخاب شده‌اند و مغازه اصلی آن‌ها را ندارد
    $partnerProducts = Product::whereIn('id', $selectedProductIds)
        ->where('status', 1)
        ->whereNotIn('name', $productNames)
        ->where('store_id', '!=', $store->id)
        ->with('store')
        ->get();

    // ادغام محصولات
    $products = $products->concat($partnerProducts);

    return view('Home.store_products', compact(
        'store',
        'products',
        'partnerProducts',
        'selectedProductIds'
    ));
}

    public function showCategoryProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->where('status', 1)->get();


        return view('Home.category_products', compact('category', 'products'));
    }

    public function search(Request $request)
    {
        $searchKey = $request->input('search_key');
        $searchType = $request->input('search_type', 'all');

        $results = [];

        if ($searchType === 'all' || $searchType === 'products') {
            $products = Product::where('status', 1)
                ->where(function($query) use ($searchKey) {
                    $query->where('name', 'like', '%' . $searchKey . '%');
                })
                ->with('category', 'store')
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get();

            $results['products'] = $products;
        }

        if ($searchType === 'all' || $searchType === 'categories') {
            $categories = Category::where('name', 'like', '%' . $searchKey . '%')
                ->withCount('products')
                ->take(10)
                ->get();

            $results['categories'] = $categories;
        }

        if ($searchType === 'all' || $searchType === 'articles') {
            $articles = Article::where('status', 1)
                ->where('title', 'like', '%' . $searchKey . '%')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $results['articles'] = $articles;
        }

        if ($searchType === 'all' || $searchType === 'stores') {
            $stores = Store::where('name', 'like', '%' . $searchKey . '%')
                ->withCount('products')
                ->take(10)
                ->get();

            $results['stores'] = $stores;
        }

        return view('Home.search_results', compact('results', 'searchKey', 'searchType'));
    }
}
