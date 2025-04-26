
@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="add-category">
    <h2>افزودن دسته‌بندی جدید</h2>
    <div class="card">
        <form method="POST" action="{{route('panel.category.store')}}">
            @csrf
            <div class="form-group">
                <label for="name">نام دسته‌بندی</label>
                <input type="text" name="name" id="name" class="form-control" value="" required>
                <!-- @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror -->
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره دسته‌بندی</button>
             
            </div>
        </form>
    </div>
</section>
@endsection