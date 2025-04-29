<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\Slider;
use App\Models\Article;
use App\Models\Category;

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
        $store = Store::findOrFail($id);
        $products = Product::where('store_id', $id)
                           ->where('status', 1)
                           ->take(12)
                           ->get();

        return view('Home.store_products', compact('store', 'products'));
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
                ->where(function($query) use ($searchKey) {
                    $query->where('title', 'like', '%' . $searchKey . '%')
                          ->orWhere('content', 'like', '%' . $searchKey . '%');
                })
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
