<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class SliderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->role == 'super_admin')
        {
            $sliders = Slider::all();
        }
        return view('Admin.Slider.index', compact('sliders'));
    }
    public function create()
    {
        return view('Admin.Slider.create');
    }
    public function store(Request $request)
    {      
            $request->validate([
                'url' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('AdminAssets/Slider-image'), $imageName);
                
                $dataForm = $request->all();
                $dataForm['image'] = $imageName;
                $dataForm['admin_id'] = Auth::id();

                Slider::create($dataForm);
                
                return redirect()->route('panel.slider.index')
                    ->with('success', 'اسلایدر با موفقیت اضافه شد');
            }
            
            return back()->with('error', 'لطفا یک تصویر انتخاب کنید');
    }
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return redirect()->route('panel.slider.index')
            ->with('success', 'اسلایدر با موفقیت حذف شد');
    }
}
