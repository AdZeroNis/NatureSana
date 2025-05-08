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
@endsection

