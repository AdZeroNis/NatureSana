@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="edit-product">
    <h2>ویرایش محصول</h2>
    <div class="card">
        <form method="POST" action="{{ route('panel.product.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
      
            <div class="form-row">
                <div class="form-group">
                    <label for="name">نام محصول</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">قیمت (تومان)</label>
                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                @if(Auth::user()->role == 'super_admin')
                <div class="form-group">
                    <label for="store_id">مغازه</label>
                    <select name="store_id" id="store_id" class="selectpicker form-control p-2 @error('store_id') is-invalid @enderror" required>
                        <option value="">انتخاب مغازه</option>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @error('store_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                @endif

                <div class="form-group">
                    <label for="category_id">دسته‌بندی</label>
                    <select name="category_id" id="category_id" class="selectpicker form-control p-2 @error('category_id') is-invalid @enderror" >
                        <option value="">انتخاب دسته‌بندی</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inventory">تعداد محصول</label>
                    <input type="number" name="inventory" id="inventory" class="form-control @error('inventory') is-invalid @enderror" value="{{ old('inventory', $product->inventory) }}" min="0" required>
                    @error('inventory')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">وضعیت</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>غیرفعال</option>
                </select>
                @error('status')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                    <label for="image">تصویر محصول</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @if($product->image)
                        <div class="image-preview">
                            <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="تصویر فعلی محصول" style="max-height: 150px; border-radius: 8px; margin-top: 1rem;">
                        </div>
                    @endif
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره تغییرات</button>
                <a href="{{ route('panel.product.index') }}" class="btn btn-cancel">لغو</a>
            </div>
        </form>
    </div>
</section>
@endsection