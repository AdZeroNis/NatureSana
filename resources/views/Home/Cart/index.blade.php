<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')

<section class="cart-section" id="cart">
    <h2>سبد خرید</h2>
    <div class="cart-container">
        @if (isset($cartItems) && count($cartItems) > 0)
            <div class="cart-items">
                @php
                    $totalPrice = 0;
                @endphp
                @foreach ($cartItems as $item)
                 @php
    $totalPrice += $item->product->price * $item->quantity;
@endphp

                    <div class="cart-item">
                     <img src="{{ asset('AdminAssets/Product-image/' . $item->product->image) }}" alt="{{ $item->product->name }}">
<h3>{{ $item->product->name }}</h3>
<p>{{ number_format($item->product->price, 0) }} تومان</p>

                          <div class="quantity-controls">
    <form action="{{ route('cart.decrease', $item->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="quantity-btn">-</button>
    </form>
    <span>{{ $item->quantity }}</span>
    <form action="{{ route('cart.increase', $item->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="quantity-btn">+</button>
    </form>
</div>
<form action="{{ route('cart.delete', $item->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این محصول مطمئن هستید؟')">
    @csrf
    @method('DELETE')
    <button type="submit" class="remove-btn">حذف</button>
</form>

                        </div>
                    </div>
                @endforeach
            </div>
            <div class="cart-summary">
                <h3>خلاصه سفارش</h3>
                <p>جمع محصولات: {{ number_format($totalPrice, 0) }} تومان</p>
                <p>هزینه ارسال: ۵۰ تومان</p>
                <p class="total">جمع کل: {{ number_format($totalPrice + 50, 0) }} تومان</p>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
               <div class="address-form">
    <label for="address">آدرس:</label>

    {{-- دکمه‌های انتخاب آدرس --}}
    @if (!empty($addresses))
        <div class="address-options" style="margin-bottom: 10px;">
            @foreach ($addresses as $addr)
                @if (!empty($addr))
                    <button type="button" class="address-btn" onclick="fillAddress(@json($addr))">
                        {{ \Illuminate\Support\Str::limit($addr, 30) }}
                    </button>
                @endif
            @endforeach
        </div>
    @endif

    {{-- textarea برای آدرس انتخاب شده یا وارد شده --}}
    <textarea id="address" name="address" required placeholder="آدرس خود و کد پستی  را وارد کنید"></textarea>
</div>


                    <button type="submit" class="checkout-btn">تأیید و پرداخت</button>
                </form>
            </div>
        @else
            <p class="empty-cart">سبد خرید شما خالی است.</p>
        @endif
    </div>
</section>

@include('Home.layouts.footer')

</body>
<script>
    function fillAddress(address) {
        document.getElementById('address').value = address;
    }
</script>
<style>
.address-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.address-btn {
    background-color: #4caf50; /* رنگ سبز */
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.address-btn:hover {
    background-color: #45a049; /* سبز تیره‌تر برای هاور */
}

.address-btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(72, 180, 97, 0.7);
}
</style>

</html>
