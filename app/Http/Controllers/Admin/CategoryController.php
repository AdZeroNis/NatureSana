<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('Admin.Category.index', compact('categories'));
    }

    public function create()
    {
        return view('Admin.Category.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Category::create([
            'name' => $request->input('name'),
            // 'store_id' => Auth::user()->store_id,
        ]);

        return redirect()->route('panel.category.index')
            ->with('success', 'دسته بندی با موفقیت اضافه شد');
    }

    public function Categories()
    {
        $user = Auth::user();
    // Fetch all categories if the user is a super admin, otherwise only categories for their store
    if ($user->role == 'super_admin') {
        $categories = Category::all();
    } else {
        $categories = Category::where('store_id', $user->store_id)->get();
    }

    return view('Admin.Category.index', compact('categories'));
     }

  public function edit($id){
        $category=Category::find($id);
        return view("Admin.Category.edit",compact("category"));
}
public function update(Request $request, $id) {
    $category = Category::find($id);
    $dataForm=$request->all();


    $category->update($dataForm);


    return redirect()->route("panel.category.index")->with('success', 'دسته بندی با موفقیت ویرایش شد');
}


    public function destroy($id){
        $category=Category::find($id);
        // if ($category->products()->exists()) {

        //     Alert::error('خطا', 'این دسته بندی دارای  محصول  است و نمی‌توان آن را حذف کرد.');
        //     return redirect()->route('panel.category.index')
        // }
         $category->delete();
         return redirect()->route('panel.category.index')
         ->with('success', 'دسته‌بندی با موفقیت حذف شد');
    }
    public function filter(Request $request)
{
    $query = Category::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }


    if ($request->has('status') && $request->status !== '') {

        if ($request->status == 'active') {
            $query->where('status', 1);
        } elseif ($request->status == 'inactive') {
            $query->where('status', 0);
        }
    }

    $categories = $query->get();


    return view('Admin.Category.index', [
        'categories' => $categories,
        'search' => $request->search,
        'status' => $request->status
    ]);
}
}
