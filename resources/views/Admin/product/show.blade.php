@extends('Admin.layouts.master')

@section('title', 'جزئیات محصول')

@section('content')
<section class="product-details">
    <div class="container">
        <div class="header">
            <h2>جزئیات محصول</h2>
            <div class="actions">
                <a href="{{ route('panel.product.edit', $product->id) }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i>
                    ویرایش
                </a>
                <a href="{{ route('panel.product.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-right"></i>
                    بازگشت
                </a>
            </div>
        </div>

        <div class="details-card">
            <div class="product-image">
                @if($product->image)
                    <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-box"></i>
                    </div>
                @endif
            </div>

            <div class="product-info">
                <div class="info-group">
                    <h3>اطلاعات اصلی</h3>
                    <div class="info-row">
                        <span class="label">نام محصول:</span>
                        <span class="value">{{ $product->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">قیمت:</span>
                        <span class="value">{{ number_format($product->price) }} تومان</span>
                    </div>
                    <div class="info-row">
                        <span class="label">دسته‌بندی:</span>
                        <span class="value">{{ $product->category ? $product->category->name : 'بدون دسته‌بندی' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">فروشگاه:</span>
                        <span class="value">{{ $store->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">تعداد:</span>
                        <span class="value">{{ $product->inventory }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">توضیحات:</span>
                        <span class="value">{{ $product->description ?: 'بدون توضیحات' }}</span>
                    </div>
                </div>

                <div class="info-group">
                    <h3>وضعیت</h3>
                    <div class="info-row">
                        <span class="label">وضعیت فعلی:</span>
                        <span class="value status-badge {{ $product->status == 1 ? 'active' : 'inactive' }}">
                            {{ $product->status == 1 ? 'فعال' : 'غیرفعال' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">تاریخ ثبت:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($product->created_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">آخرین بروزرسانی:</span>
                        <span class="value">{{ \Morilog\Jalali\Jalalian::fromDateTime($product->updated_at)->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection