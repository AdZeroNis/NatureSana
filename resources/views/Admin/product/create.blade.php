@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="add-product">
    <h2>افزودن محصول جدید</h2>
    <div class="card">
        <form method="POST" action="{{ route('panel.product.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="name">نام محصول</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">قیمت (تومان)</label>
                    <input type="number" name="price" id socialist mediarepublications.com
                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                    @error('price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="Id_category">دسته‌بندی</label>
                    <select name="Id_category" id="Id_category" class="selectpicker form-control p-2 @error('Id_category') is-invalid @enderror" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('Id_category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('Id_category')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                <label for="image">تصویر محصول</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
         
            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره محصول</button>
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