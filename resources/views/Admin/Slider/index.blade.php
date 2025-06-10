@extends('Admin.layouts.master')

@section('content')
<section class="table-section" id="products">
    <h2>مدیریت اسلایدرها</h2>


    <div class="add-item my-3">
        <a href="{{ route('panel.slider.create') }}" class="btn btn-add">افزودن اسلایدر جدید</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>لینک</th>
                <th>عکس</th>
<th> تاریخ ثبت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sliders as $slider)
            <tr>
                <td>{{ $slider->id }}</td>
                <td>{{ $slider->url }}</td>
                <td><span><img src="{{asset("AdminAssets/Slider-image/".$slider->image)}}" width="70px" ></span></td>

<td>{{ \Morilog\Jalali\Jalalian::fromDateTime($slider->created_at)->format('Y/m/d H:i') }}</td>
                <td class="action-buttons">

                    <a href="#"
                       class="btn btn-sm"
                       style="color: red;"
                       title="حذف"
                       onclick="event.preventDefault(); if(confirm('آیا از حذف این محصول مطمئن هستید؟')) {
                           document.getElementById('delete-form-{{ $slider->id }}').submit(); }">
                        <i class="fas fa-trash-alt"></i>
                    </a>

                    <form id="delete-form-{{ $slider->id }}" action="{{ route('panel.slider.delete', $slider->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">هیچ اسلایدری یافت نشد</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection
