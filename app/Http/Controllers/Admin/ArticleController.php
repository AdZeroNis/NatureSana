<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function index()
    {
      $user = Auth::user();
       
      if($user->role == 'super_admin')
      {
        $articles = Article::all();
    
      }
      else{
        $articles = Article::where('user_id',$user->id)->get();
      }

      return view('Admin.Article.index', compact('articles'));
    }

    public function create()
    {
        return view('Admin.Article.create');
    }

    public function store(Request $request)
    {

        $request->validate([

            'title'=> 'required',
            'image'=> 'required',
            'content'=> 'required',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('AdminAssets/Article-image'), $imageName);

        Article::create([
            'title' => $request->title,
            'image' => $imageName,
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('panel.article.index')->with('success', 'مقاله با موفقیت اضافه شد');
    }   

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('Admin.Article.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
       
        $article = Article::find($id);


        $dataForm = $request->except('image');
    
    
        if ($request->hasFile('image')) {
            $imageName = time() . "." . $request->image->extension();
            $request->image->move(public_path("AdminAssets/Article-image"), $imageName);
            $dataForm['image'] = $imageName;
    
    
            $picture = public_path("AdminAssets/Article-image/") . $article->image;
            if (File::exists($picture)) {
                File::delete($picture);
            }
        }
    
        $article->update($dataForm);
    
        return redirect()->route('panel.article.index')
            ->with('success', 'مقاله با موفقیت ویرایش شد');
    }

    public function destroy($id){
        $article=Article::find($id);
           // حذف تصویر قبلی اگر وجود داشت
           $picture = public_path("AdminAssets/Article-image/") . $article->image;
           if(File::exists($picture))
           {
               File::delete($picture);  
           }
         $article->delete();
    
         return redirect()->route("panel.article.index")->with('success', 'مقاله با موفقیت حذف شد');;
    }


    public function filter(Request $request)
    {
     $query = Article::query();
     
     // جستجو بر اساس نام
     if ($request->filled('search')) {
         $query->where('title', 'like', '%' . $request->search . '%');
     }
 
     // فیلتر بر اساس وضعیت فعال/غیرفعال
     if ($request->filled('status')) {
         if ($request->status === 'active') {
             $query->where('status', 1);
         } elseif ($request->status === 'inactive') {
             $query->where('status', 0);
         }
     }
 
 
 
     $articles = $query->latest()->paginate(10);
 
     return view('Admin.Article.index', [
         'articles' => $articles,
         'search' => $request->search,
         'status' => $request->status,
     ]);
    }

    public function show($id)
    {
        $currentUser = Auth::user();

        if ($currentUser->role == 'super_admin') {

            $article = Article::find($id);


            return view('Admin.Article.show', compact('article'));
        }

        $article = Article::find($id);

        return view('Admin.Article.show', compact('article'));
    }

}
