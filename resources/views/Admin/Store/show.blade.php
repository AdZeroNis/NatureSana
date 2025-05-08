@extends('Admin.layouts.master')

@section('title', 'جزئیات مغازه')

@section('content')
<section class="store-details">
    <div class="container">
        <div class="header">
            <h2>جزئیات مغازه</h2>
            <div class="actions">
                <a href="{{ route('store.edit', $store->id) }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i>
                    ویرایش
                </a>
                <a href="{{ route('store.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-right"></i>
                    بازگشت
                </a>
            </div>
        </div>

        <div class="details-card">
            <div class="store-image">
                @if($store->image)
                    <img src="{{ asset('AdminAssets/Store-image/' . $store->image) }}" alt="{{ $store->name }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-store"></i>
                    </div>
                @endif
            </div>

            <div class="store-info">
                <div class="info-group">
                    <h3>اطلاعات اصلی</h3>
                    <div class="info-row">
                        <span class="label">نام مغازه:</span>
                        <span class="value">{{ $store->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">شماره تلفن:</span>
                        <span class="value">{{ $store->phone_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">آدرس:</span>
                        <span class="value">{{ $store->address }}</span>
                    </div>
                </div>

                <div class="info-group">
                    <h3>وضعیت</h3>
                    <div class="info-row">
                        <span class="label">وضعیت فعلی:</span>
                        <span class="value status-badge {{ $store->status == 1 ? 'active' : ($store->status == 0 ? 'inactive' : 'pending') }}">
                            @if($store->status == 1)
                                فعال
                            @elseif($store->status == 0)
                                غیرفعال
                            @else
                                در انتظار تایید
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">تاریخ ثبت:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($store->created_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">آخرین بروزرسانی:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($store->updated_at)->format('Y/m/d H:i') }}</span>
                    </div>
                </div>

                @if($store->admin)
                <div class="info-group">
                    <h3>اطلاعات مدیر</h3>
                    <div class="info-row">
                        <span class="label">نام مدیر:</span>
                        <span class="value">{{ $store->admin->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">ایمیل:</span>
                        <span class="value">{{ $store->admin->email }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
