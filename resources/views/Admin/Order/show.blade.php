@extends('Admin.layouts.master')

@section('content')

<section class="order-details-section" id="order-details">
    <h2>جزئیات سفارش</h2>
    <div class="order-details-container">
        <div class="order-summary">
            <h3>خلاصه سفارش</h3>
<p><strong>نام خریدار:</strong> {{ $order->user->name ?? '---' }}</p>
<p><strong>آدرس:</strong> {{ $order->address }}</p>
<p><strong>تاریخ سفارش:</strong> {{ $order->created_at->format('Y/m/d H:i') }}</p>
<p><strong>وضعیت:</strong>
    @if($order->status == 0)
        <span class="order-status processing">در حال پردازش</span>
    @elseif($order->status == 1)
        <span class="order-status processing" style="background-color: blue">ارسال شده</span>
    @else
        <span class="order-status processing" style="background-color: red">لغو شده</span>
    @endif
</p>
<p><strong>فروشگاه همکار:</strong> {{ optional($order->orderItems->first())->sellerStore->name ?? '---' }}</p>

<p><strong>تعداد آیتم‌ها:</strong> {{ $order->orderItems->sum('quantity') }}</p>
<p><strong>جمع محصولات:</strong> {{ number_format($order->total_price, 0) }} تومان</p>
<p><strong>هزینه ارسال:</strong> ۵۰ تومان</p>
<p class="total"><strong>جمع کل:</strong> {{ number_format($order->total_price + 50, 0) }} تومان</p>
<p><strong>سهم فروشگاه اصلی:</strong> {{ number_format($totalOwnerShare, 0) }} تومان</p>
<p><strong>سهم فروشگاه همکار:</strong> {{ number_format($totalSellerShare, 0) }} تومان</p>


        </div>

        <div class="order-items">
            <h3>محصولات سفارش</h3>
            @if (isset($order->orderItems) && count($order->orderItems) > 0)
                <div class="items-list">
            @foreach ($order->orderItems as $item)
    <div class="order-item">
        <img src="{{ asset('AdminAssets/Product-image/' . ($item->product->image ?? 'default.jpg')) }}" alt="{{ $item->product->name }}">
        <div class="item-details">
            <h4>{{ $item->product->name }}</h4>
            <p><strong>تعداد:</strong> {{ $item->quantity }}</p>
            <p><strong>قیمت واحد:</strong> {{ number_format($item->product->price ?? 0, 0) }} تومان</p>
            <p><strong>جمع:</strong> {{ number_format(($item->product->price ?? 0) * $item->quantity, 0) }} تومان</p>
        </div>
    </div>
@endforeach

                </div>
            @else
                <p class="empty-items">هیچ محصولی در این سفارش یافت نشد.</p>
            @endif
        </div>
    </div>
</section>

<style>
.order-details-section {
    max-width: 1300px;
    margin: 3rem auto;
    padding: 0 1.5rem;
    direction: rtl;
}

.order-details-container {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.order-summary {
    flex: 1;
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.order-summary h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: var(--text-color);
    margin: 0;
}

.order-summary p {
    font-family: 'Arial', sans-serif;
    font-size: 1rem;
    color: var(--text-color);
    margin: 0.5rem 0;
}

.order-summary p strong {
    margin-left: 0.5rem;
}

.order-summary .total {
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--accent-color);
}

.order-status {
    font-family: 'Arial', sans-serif;
    font-size: 0.9rem;
    padding: 0.4rem 0.8rem;
    border-radius: 25px;
    color: white;
    display: inline-block;
}

.order-status.processing {
    background: #f39c12; /* Orange for processing */
}

.order-items {
    flex: 2;
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.order-items h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: var(--text-color);
    margin: 0 0 1rem;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #eee;
}

.order-item:last-child {
    border-bottom: none;
}

.order-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
}

.item-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.item-details h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    color: var(--text-color);
    margin: 0;
}

.item-details p {
    font-family: 'Arial', sans-serif;
    font-size: 0.9rem;
    color: var(--text-color);
    margin: 0;
}

.item-details p strong {
    margin-left: 0.5rem;
}

.empty-items {
    font-family: 'Arial', sans-serif;
    font-size: 1.2rem;
    color: var(--text-color);
    text-align: center;
    margin: 2rem 0;
}

@media (max-width: 1024px) {
    .order-details-container {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .order-details-section {
        padding: 0 1rem;
    }

    .order-summary h3, .order-items h3 {
        font-size: 1.1rem;
    }

    .order-summary p, .item-details p {
        font-size: 0.9rem;
    }

    .order-summary .total {
        font-size: 1rem;
    }

    .order-item img {
        width: 60px;
        height: 60px;
    }

    .item-details h4 {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .order-summary, .order-items {
        padding: 1rem;
    }

    .order-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: right;
    }

    .order-item img {
        width: 100%;
        height: 100px;
        margin-bottom: 0.5rem;
    }
}
</style>

@endsection
