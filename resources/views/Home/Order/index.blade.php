<!DOCTYPE html>
<html lang="fa">
@include('Home.layouts.head')
<body>
@include('Home.layouts.header')

<section class="orders-section" id="orders">
    <h2>سفارش‌های من</h2>
    <div class="orders-container">
        @if (isset($orders) && count($orders) > 0)
            <div class="orders-list">
            @foreach ($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <h3>سفارش شما:</h3>
            @if($order->status == 0)
            <span class="order-status processing">درحال پردازش</span>
            @elseif($order->status == 1)
             <span class="order-status processing" style="background-color: blue">درحال ارسال</span>
             @elseif($order->status == 2)
             <span class="order-status processing" style="background-color: red">عدم ارسال</span>
             @endif

        </div>
        <div class="order-details">
            <p><strong>تاریخ سفارش:</strong> {{ $order->created_at->format('Y/m/d') }}</p>
            <p><strong>جمع کل:</strong> {{ number_format($order->total_price + 50, 0) }} تومان</p>
            <p><strong>آدرس تحویل:</strong> {{ $order->address }}</p>

            <p><strong>محصولات:</strong></p>
            <ul>
                @foreach ($order->orderItems as $item)
                    <li>{{ $item->product->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach

            </div>
        @else
            <p class="empty-orders">شما هنوز سفارشی ثبت نکرده‌اید.</p>
        @endif
    </div>
</section>

@include('Home.layouts.footer')

</body>
</html>
