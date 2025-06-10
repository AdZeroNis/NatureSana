
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
            <div class="form-row">
                @if(Auth::user()->role == 'super_admin')
                <div class="form-group">
                    <label for="store_id">مغازه</label>
                    <select name="store_id" id="store_id" class="selectpicker form-control p-2 @error('store_id') is-invalid @enderror" required>
                        <option value="">انتخاب مغازه</option>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @error('store_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                @endif

            </div>

            <div class="form-actions" style="margin-right: 211px !important ;">
                <button type="submit" class="btn btn-submit">ذخیره دسته‌بندی</button>

            </div>
        </form>
    </div>
</section>
@endsection
