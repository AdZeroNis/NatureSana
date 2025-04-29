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

<style>
.product-details {
    padding: 2rem;
    background-color: #f8f9fa;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header h2 {
    font-size: 1.8rem;
    color: var(--primary-color);
    margin: 0;
}

.actions {
    display: flex;
    gap: 1rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn i {
    font-size: 1.1rem;
}

.btn-edit {
    background-color: var(--accent-color);
    color: white;
}

.btn-edit:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
}

.btn-back {
    background-color: #e9ecef;
    color: #495057;
}

.btn-back:hover {
    background-color: #dee2e6;
    transform: translateY(-2px);
}

.details-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    display: flex;
    gap: 2rem;
    padding: 2rem;
}

.product-image {
    flex: 0 0 300px;
    height: 300px;
    border-radius: 10px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-image i {
    font-size: 4rem;
    color: #adb5bd;
}

.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.info-group {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
}

.info-group h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.info-row {
    display: flex;
    margin-bottom: 0.75rem;
    align-items: center;
}

.info-row:last-child {
    margin-bottom: 0;
}

.label {
    flex: 0 0 150px;
    color: #6c757d;
    font-weight: 500;
}

.value {
    color: #212529;
}

.status-badge {
    padding: 0.25rem 1rem;
    border-radius: 15px;
    font-size: 0.9rem;
}

.status-badge.active {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.inactive {
    background-color: #f8d7da;
    color: #721c24;
}

@media (max-width: 768px) {
    .product-details {
        padding: 1rem;
    }

    .header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .details-card {
        flex-direction: column;
        padding: 1rem;
    }

    .product-image {
        flex: 0 0 200px;
        height: 200px;
    }

    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .label {
        flex: none;
    }
}
</style>
@endsection