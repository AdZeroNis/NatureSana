@extends('Admin.layouts.master')

@section('title', 'جزئیات کاربر')

@section('content')
<section class="product-details">
    <div class="container">
        <div class="header">
            <h2>جزئیات کاربر</h2>
            <div class="actions">
                <a href="{{ route('panel.user.edit', $user->id) }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i>
                    ویرایش
                </a>
                <a href="{{ route('panel.user.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-right"></i>
                    بازگشت
                </a>
            </div>
        </div>

        <div class="details-card">

            <div class="product-info">
                <div class="info-group">
                    <h3>اطلاعات اصلی</h3>
                    <div class="info-row">
                        <span class="label">نام کاربری:</span>
                        <span class="value">{{ $user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">ایمیل:</span>
                        <span class="value">{{ $user->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">شماره تلفن:</span>
                        <span class="value">{{ $user->phone }}</span>
                    </div>
                </div>

                <!-- آدرس‌های کاربر -->
                <div class="info-group">
                    <h3>🏠 آدرس‌ها</h3>
                    @if($user->address)
                        <div class="address-list">
                            @if($user->address->address_one)
                                <div class="info-row">
                                    <span class="label">آدرس 1:</span>
                                    <span class="value">{{ $user->address->address_one }}</span>
                                </div>
                            @endif

                            @if($user->address->address_two)
                                <div class="info-row">
                                    <span class="label">آدرس 2:</span>
                                    <span class="value">{{ $user->address->address_two }}</span>
                                </div>
                            @endif

                            @if($user->address->address_three)
                                <div class="info-row">
                                    <span class="label">آدرس 3:</span>
                                    <span class="value">{{ $user->address->address_three }}</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="no-address">هیچ آدرسی ثبت نشده است</p>
                    @endif
                </div>

                <!-- اطلاعات مغازه (اگر ادمین باشد) -->
                @if($user->role == 'admin' && $user->store)
                <div class="info-group">
                    <h3>🏪 اطلاعات مغازه</h3>
                    <div class="store-info">
                        <div class="info-row">
                            <span class="label">نام مغازه:</span>
                            <span class="value">{{ $user->store->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">آدرس مغازه:</span>
                            <span class="value">{{ $user->store->address }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">شماره تماس مغازه:</span>
                            <span class="value">{{ $user->store->phone_number }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">وضعیت مغازه:</span>
                            <span class="value status-badge {{ $user->store->status == 1 ? 'active' : 'inactive' }}">
                                {{ $user->store->status == 1 ? 'فعال' : 'در انتظار تایید' }}
                            </span>
                        </div>
                        
                        @if($user->store->image)
                        <div class="store-image">
                            <img src="{{ asset('AdminAssets/Store-image/' . $user->store->image) }}" alt="تصویر مغازه" style="width: 213px;">
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="info-group">
                    <h3>وضعیت</h3>
                    <div class="info-row">
                        <span class="label">وضعیت فعلی:</span>
                        <span class="value status-badge {{ $user->status == 1 ? 'active' : 'inactive' }}">
                            {{ $user->status == 1 ? 'فعال' : 'غیرفعال' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">تاریخ ثبت:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($user->created_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">آخرین بروزرسانی:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($user->updated_at)->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection