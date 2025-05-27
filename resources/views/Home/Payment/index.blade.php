@extends('Home.layouts.master')

@section('content')

<section class="orders-section" id="orders">
    <h2>سفارش‌های من</h2>
    <div class="orders-container">
        @if (isset($orders) && count($orders) > 0)
            <div class="orders-list">
                @foreach ($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <h3>سفارش شماره: {{ $order->id }}</h3>
                            <span class="order-status {{ $order->status_class }}">
                                {{ $order->status_text }}
                            </span>
                        </div>
                        <div class="order-details">
                            <p><strong>تاریخ سفارش:</strong> {{ $order->created_at->format('Y/m/d') }}</p>
                            <p><strong>جمع کل:</strong> {{ number_format($order->total_price + 50, 0) }} تومان</p>
                            <p><strong>آدرس تحویل:</strong> {{ $order->address }}</p>
                        </div>
                        <a href="{{ route('order.show', $order->id) }}" class="view-details-btn">مشاهده جزئیات</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="empty-orders">شما هنوز سفارشی ثبت نکرده‌اید.</p>
        @endif
    </div>
</section>

<style>
.orders-section {
    max-width: 1300px;
    margin: 3rem auto;
    padding: 0 1.5rem;
    direction: rtl;
}

.orders-container {
    display: flex;
    flex-direction: column;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.order-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.order-header h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: var(--text-color);
    margin: 0;
}

.order-status {
    font-family: 'Arial', sans-serif;
    font-size: 0.9rem;
    padding: 0.4rem 0.8rem;
    border-radius: 25px;
    color: white;
}

.order-status.pending {
    background: #f39c12;
}

.order-status.shipped {
    background: #3498db;
}

.order-status.delivered {
    background: #2ecc71;
}

.order-status.cancelled {
    background: #e74c3c;
}

.order-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.order-details p {
    font-family: 'Arial', sans-serif;
    font-size: 1rem;
    color: var(--text-color);
    margin: 0;
}

.order-details p strong {
    color: var(--text-color);
    margin-left: 0.5rem;
}

.view-details-btn {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-family: 'Arial', sans-serif;
    font-size: 0.9rem;
    text-align: center;
    display: inline-block;
    transition: background 0.3s ease;
}

.view-details-btn:hover {
    background: var(--secondary-color);
}

.empty-orders {
    font-family: 'Arial', sans-serif;
    font-size: 1.2rem;
    color: var(--text-color);
    text-align: center;
    margin: 2rem 0;
}

@media (max-width: 1024px) {
    .orders-section {
        padding: 0 1rem;
    }
}

@media (max-width: 768px) {
    .order-header h3 {
        font-size: 1.1rem;
    }

    .order-status {
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
    }

    .order-details p {
        font-size: 0.9rem;
    }

    .view-details-btn {
        font-size: 0.8rem;
        padding: 0.4rem 1.2rem;
    }
}

@media (max-width: 480px) {
    .order-card {
        padding: 1rem;
    }

    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .order-header h3 {
        font-size: 1rem;
    }

    .order-details p {
        font-size: 0.85rem;
    }
}
</style>

@endsection
