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
                    <select name="category_id" id="category_id" class="selectpicker form-control p-2 @error('category_id') is-invalid @enderror" required>
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

<style>
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        max-width: 1000px;
        margin: 3rem auto;
    }

    .form-section h2 {
        font-family: 'Vazir', sans-serif;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 1.5rem;
    }

    .card {
        padding: 1rem;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
        color: var(--text-color);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 5px rgba(67, 160, 71, 0.3);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-control.is-invalid {
        border-color: var(--accent-color);
    }

    .error {
        color: var(--accent-color);
        font-size: 0.9rem;
        margin-top: 0.25rem;
        display: block;
    }

    .image-preview {
        margin-top: 1rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 25px;
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .btn-submit {
        background: var(--accent-color);
        color: white;
    }

    .btn-submit:hover {
        background: var(--secondary-color);
        transform: scale(1.05);
    }

    .btn-cancel {
        background: #ddd;
        color: var(--text-color);
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-cancel:hover {
        background: #ccc;
        transform: scale(1.05);
    }

    .selectpicker {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .form-group {
            min-width: 100%;
        }

        .form-section {
            margin: 1rem;
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection