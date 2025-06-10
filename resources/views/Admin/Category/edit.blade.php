@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="add-category">
    <h2>ویرایش دسته‌بندی</h2>
    <div class="card">
        <form method="POST" action="{{route('panel.category.update', $category->id)}}">
            @csrf

            <div class="form-group">
                <label for="name">نام دسته‌بندی</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                <!-- @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror -->
            </div>

            <div class="form-group">
                <label for="status" class="d-block">وضعیت</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                    <option value="2" {{ $category->status == 2 ? 'selected' : '' }}>همه</option>
                </select>
            </div>

            <div class="form-actions" style="margin-right: 211px !important ;">
                <button type="submit" class="btn btn-submit">ویرایش دسته‌بندی</button>
            </div>
        </form>
    </div>
</section>
@endsection
