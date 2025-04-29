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
    public function filter(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
    
        if ($request->has('role') && $request->role !== '') {
    
            if ($request->role == 'user') {
                $query->where('role', 'user');
            } elseif ($request->role == 'admin') {
                $query->where('role', 'admin');
            }
    
        }
        if ($request->has('status') && $request->status !== '') {
    
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
    
        }
    
        $Users = $query->get();
    
    
        return view('Admin.User.index', [
            'users' => $Users,
            'search' => $request->search,
            'role' => $request->role,
            'status' => $request->status,
        ]);
    }

}
