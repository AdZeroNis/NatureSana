<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment as ProductCommentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductComment extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'content' => 'required|string|min:2'
        ]);

        $comment = new ProductCommentModel([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $comment->save();

        return redirect()->back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد');
    }

    public function reply(Request $request, ProductCommentModel $comment)
    {
        $request->validate([
            'content' => 'required|string|min:2'
        ]);

        $reply = new ProductCommentModel([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'product_id' => $comment->product_id,
            'parent_id' => $comment->id,
        ]);

        $reply->save();

        return redirect()->back()->with('success', 'پاسخ شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد');
    }
    public function index()
    {
        $user = Auth::user();
        $query = ProductCommentModel::with('user', 'product');
        
        if ($user->role != 'super_admin') {
            $query->whereHas('product', function($q) use ($user) {
                $q->where('store_id', $user->store_id);
            });
        }
        
        $comments = $query->latest()->paginate(15);
        
        return view('Admin.Comment.index', compact('comments'));
    }
    public function destroy($id)
    {
        $comment = ProductCommentModel::findOrFail($id);
        // If this is a main comment (no parent), delete all replies first
        if (!$comment->parent_id) {
            $comment->replies()->delete();
        }
        
        $comment->delete();
        return redirect()->back()->with('success', 'نظر با موفقیت حذف شد');
    }
    
}
