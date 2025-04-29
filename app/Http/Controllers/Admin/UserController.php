<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['address', 'store'])->get();
        return view("Admin.User.index", compact("users"));
    }
    public function show($id)
    {
        $user = User::with(['address', 'store'])->findOrFail($id);
        return view("Admin.User.show", compact("user"));
    }

    public function edit($id)
    {
        $user = User::with(['address', 'store'])->findOrFail($id);
        return view("Admin.User.edit", compact("user"));
    }
    public function update(Request $request, $id)
    {
        $user = User::with(['address', 'store'])->findOrFail($id);
        $user->update($request->all());
        return redirect()->route('panel.user.index')->with('success', 'کاربر با موفقیت ویرایش شد');
    }
    public function destroy($id)
    {
        $user = User::with(['address', 'store'])->findOrFail($id);
        $user->delete();
        return redirect()->route('panel.user.index')->with('success', 'کاربر با موفقیت حذف شد');
    }
  

}
