@extends('Admin.layouts.master')

@section('title', 'جزئیات سبد خرید')

@section('content')
<section class="product-details">
    <div class="container">
        <div class="header">
            <h2>جزئیات سبد خرید</h2>
            <div class="actions">
                <a href="{{ route('panel.cart.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-right"></i>
                    بازگشت
                </a>
            </div>
        </div>

        <div class="details-card">
            <div class="product-image">
                @if($cart->product->image)
                    <img src="{{ asset('AdminAssets/Product-image/' . $cart->product->image) }}" alt="{{ $cart->product->name }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-box"></i>
                    </div>
                @endif
            </div>

            <div class="product-info">
                <div class="info-group">
                    <h3>اطلاعات کاربر</h3>
                    <div class="info-row">
                        <span class="label">نام کاربر:</span>
                        <span class="value">{{ $user->name ?? 'نامشخص' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">ایمیل:</span>
                        <span class="value">{{ $user->email ?? 'نامشخص' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">نقش:</span>
                        <span class="value">
                            @if($user->role == 'admin')
                                مدیر
                            @elseif($user->role == 'super_admin')
                                سوپر ادمین
                            @else
                                کاربر عادی
                            @endif
                        </span>
                    </div>
                </div>

                <div class="info-group">
                    <h3>اطلاعات محصول</h3>
                    <div class="info-row">
                        <span class="label">نام محصول:</span>
                        <span class="value">{{ $cart->product->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">قیمت:</span>
                        <span class="value">{{ number_format($cart->product->price) }} تومان</span>
                    </div>
                    <div class="info-row">
                        <span class="label">دسته‌بندی:</span>
                        <span class="value">{{ $cart->product->category ? $cart->product->category->name : 'بدون دسته‌بندی' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">فروشگاه:</span>
                        <span class="value">{{ $store->name }}</span>
                    </div>
                    @if(!is_null($partnerStoreName))
                        <div class="info-row">
                            <span class="label">فروشگاه شریک:</span>
                            <span class="value">{{ $partnerStoreName }}</span>
                        </div>
                    @endif
                </div>

                <div class="info-group">
                    <h3>اطلاعات زمانی</h3>
                    <div class="info-row">
                        <span class="label">تاریخ ثبت:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($cart->created_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">آخرین بروزرسانی:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($cart->updated_at)->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
