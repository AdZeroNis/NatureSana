@extends('Admin.layouts.master')

@section('title', 'ویرایش مغازه')

@section('content')
<section class="form-section" id="edit-store">
    <h2>ویرایش مغازه</h2>
    <div class="card">
        <form method="POST" action="{{ route('store.update', $store->id) }}" enctype="multipart/form-data">
            @csrf
      
            <div class="form-row">
                <div class="form-group">
                    <label for="name">نام مغازه</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $store->name) }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone_number">شماره تلفن</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                        value="{{ old('phone_number', $store->phone_number) }}" required>
                    @error('phone_number')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group full-width">
                <label for="address">آدرس</label>
                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                    rows="4" required>{{ old('address', $store->address) }}</textarea>
                @error('address')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="status">وضعیت</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="1" {{ $store->status == 1 ? 'selected' : '' }}>فعال</option>
                        <option value="0" {{ $store->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                        <option value="2" {{ $store->status == 2 ? 'selected' : '' }}>همه</option>
                    </select>
                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">تصویر مغازه</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                    @if($store->image)
                        <div class="image-preview">
                            <img src="{{ asset('AdminAssets/Store-image/' . $store->image) }}" alt="تصویر فعلی مغازه">
                        </div>
                    @endif
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره</button>
                <a href="{{ route('store.index') }}" class="btn btn-cancel">لغو</a>
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
        max-width: 800px;
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
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        flex: 1;
        min-width: 0;
    }

    .form-group.full-width {
        margin-bottom: 1.5rem;
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

    .image-preview img {
        max-height: 150px;
        border-radius: 8px;
        border: 1px solid #ddd;
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

    @media (max-width: 768px) {
        .form-section {
            margin: 1rem;
            padding: 1.5rem;
        }

        .form-row {
            flex-direction: column;
            gap: 0.5rem;
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

@section('scripts')
<script>
    // نمایش نام فایل انتخاب شده در input
    document.querySelector('#image').addEventListener('change', function() {
        const fileName = this.files[0]?.name || 'انتخاب فایل';
        this.nextElementSibling.textContent = fileName;
    });
</script>
@endsection