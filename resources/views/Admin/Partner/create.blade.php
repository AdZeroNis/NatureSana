@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="add-partner">
    <h2>افزودن همکاری جدید</h2>
    <div class="card">
        <form method="POST" action="{{ route('panel.partner.store') }}">
            @csrf

            @if(Auth::user()->role == 'super_admin')
                <div class="form-group">
                    <label for="store_id">فروشگاه اصلی</label>
                    <select name="store_id" id="store_id" class="form-control @error('store_id') is-invalid @enderror" required>
                        <option value="">انتخاب فروشگاه</option>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                        @endforeach
                    </select>
                    @error('store_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label for="partner_store_id">فروشگاه همکار</label>
                <select name="partner_store_id" id="partner_store_id" class="form-control @error('partner_store_id') is-invalid @enderror" required>
                    <option value="">انتخاب فروشگاه همکار</option>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}" {{ old('partner_store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                    @endforeach
                </select>
                @error('partner_store_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

    

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره همکاری</button>
                <a href="{{ route('panel.partner.index') }}" class="btn btn-cancel">لغو</a>
            </div>
        </form>
    </div>
</section>
@endsection
