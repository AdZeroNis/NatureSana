<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment as ProductCommentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCommentController extends Controller
{
    public function hasAdminReply(ProductCommentModel $comment)
    {
        return $comment->replies()
            ->whereIn('user_id', function($query) {
                $query->select('id')
                    ->from('users')
                    ->whereIn('role', ['admin', 'super_admin']);
            })
            ->exists();
    }

    public function store(Request $request, Product $product)
    {

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

        $reply = new ProductCommentModel([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'product_id' => $comment->product_id,
            'parent_id' => $comment->id,
        ]);

        $reply->save();

        return redirect()->back()->with('success', 'پاسخ شما با موفقیت ثبت شد');
    }
    public function index()
    {
        $user = Auth::user();
        $query = ProductCommentModel::with(['user', 'product', 'replies.user'])
        ->whereNull('parent_id'); // Only get main comments

        if ($user->role != 'super_admin') {
            $query->whereHas('product', function($q) use ($user) {
                $q->where('store_id', $user->store_id);
            });
        }

        $comments = $query->latest()->paginate(15);

        return view('Admin.ProductComment.index', compact('comments'));
    }
   public function destroy($id)
    {
        $comment = ProductCommentModel::findOrFail($id);

        // اگر کامنت اصلی است، همه پاسخ‌ها را حذف کن
        if (!$comment->parent_id) {
            $comment->replies()->delete();
        }

        $comment->delete();

        return redirect()->back()->with('success', 'نظر با موفقیت حذف شد');
    }

 

    public function show($id)
    {
        $comment = ProductCommentModel::with(['user', 'product', 'replies.user'])
            ->findOrFail($id);

        return view('Admin.ProductComment.show', compact('comment'));
    }
}
