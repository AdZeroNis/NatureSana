<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment as ArticleCommentModel;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleCommentController extends Controller
{
    public function hasAdminReply(ArticleCommentModel $comment)
    {
        return $comment->replies()
            ->whereIn('user_id', function($query) {
                $query->select('id')
                    ->from('users')
                    ->whereIn('role', ['admin', 'super_admin']);
            })
            ->exists();
    }

    public function store(Request $request, Article $article)
    {

        $comment = new ArticleCommentModel([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'article_id' => $article->id,
        ]);

        $comment->save();

        return redirect()->back()->with('success', 'نظر شما با موفقیت ثبت شد');
    }

    public function reply(Request $request, ArticleCommentModel $comment)
    {
      
        $reply = new ArticleCommentModel([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'article_id' => $comment->article_id,
            'parent_id' => $comment->id,
        ]);

        $reply->save();

        return redirect()->back()->with('success', 'پاسخ شما با موفقیت ثبت شد');
    }
    public function index()
    {
        $user = Auth::user();
        $query = ArticleCommentModel::with(['user', 'article', 'replies.user'])
        ->whereNull('parent_id'); // Only get main comments

        if ($user->role != 'super_admin') {
            $query->whereHas('article', function($q) use ($user) {
                $q->where('store_id', $user->store_id);
            });
        }

        $comments = $query->latest()->paginate(15);

        return view('Admin.ArticleComment.index', compact('comments'));
    }
    public function destroy($id)
    {
        $comment = ArticleCommentModel::findOrFail($id);
        // If this is a main comment (no parent), delete all replies first
        if (!$comment->parent_id) {
            $comment->replies()->delete();
        }

        $comment->delete();
        return redirect()->back()->with('success', 'نظر با موفقیت حذف شد');
    }
    public function show($id)
    {
        $comment = ArticleCommentModel::with(['user', 'article', 'replies.user'])
            ->findOrFail($id);

        return view('Admin.ArticleComment.show', compact('comment'));
    }
}
