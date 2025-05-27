<!DOCTYPE html>
<html lang="fa">
@include('Home.layouts.head')
<body>
@include('Home.layouts.header')

<section class="cart-section" id="cart">
    <h2>سبد خرید</h2>

    {{-- پیام‌های موفقیت یا خطا --}}
    @if(session('success'))
        <div class="alert alert-success" style="color: green; background-color: #e6ffe6; padding: 15px; border-radius: 5px; margin: 15px auto; width: 100%; max-width: 1000px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="color: red; background-color: #ffe6e6; padding: 15px; border-radius: 5px; margin: 15px auto; width: 100%; max-width: 1000px; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    <div class="cart-container">
        @if (isset($cartItems) && count($cartItems) > 0)
            <div class="cart-items">
                @php $totalPrice = 0; @endphp
                @foreach ($cartItems as $item)
                    @php
                        $totalPrice += $item->product->price * $item->quantity;
                    @endphp

                    <div class="cart-item">
                        <img src="{{ asset('AdminAssets/Product-image/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                        <h3>{{ $item->product->name }}</h3>
                        <p>{{ number_format($item->product->price, 0) }} تومان</p>

                        <div class="quantity-control">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="quantity-form">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="action" value="">

                                <button type="submit" class="quantity-btn minus" onclick="setAction(this.form, 'decrease')">-</button>

                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->inventory + $item->quantity }}" class="quantity-input" readonly>

                                <button type="submit" class="quantity-btn plus" onclick="setAction(this.form, 'increase')">+</button>
                            </form>
                        </div>

                        <form action="{{ route('cart.delete', $item->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این محصول مطمئن هستید؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn">حذف</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h3>خلاصه سفارش</h3>
                <p>جمع محصولات: {{ number_format($totalPrice, 0) }} تومان</p>
                <p>هزینه ارسال: ۵۰ تومان</p>
                <p class="total">جمع کل: {{ number_format($totalPrice + 50000, 0) }} تومان</p>

                <form action="{{ route('payment') }}" method="GET">
                    @csrf
                    <div class="address-form">
    <label for="address">آدرس:</label>

    @if(!empty($addresses) && count(array_filter($addresses)) > 0)
        <select name="address" id="address" required>
            <option value="">آدرس را انتخاب کنید</option>
            @foreach ($addresses as $addr)
                @if(!empty($addr))
                    <option value="{{ $addr }}" @if(old('address') == $addr) selected @endif>{{ $addr }}</option>
                @endif
            @endforeach
        </select>
        <p>یا اگر می‌خواهید آدرس جدید وارد کنید:</p>
        <textarea name="address_new" rows="3" placeholder="آدرس جدید را وارد کنید"></textarea>
    @else
        <textarea name="address" id="address" rows="4" required placeholder="لطفا آدرس خود را وارد کنید">{{ old('address') }}</textarea>
    @endif
</div>


                    <button type="submit" class="submit-order-btn">ثبت سفارش و پرداخت</button>
                </form>
            </div>

        @else
            <p>سبد خرید شما خالی است.</p>
        @endif
    </div>
</section>

@include('Home.layouts.footer')

<script>
function setAction(form, action) {
    form.querySelector('input[name="action"]').value = action;
}
</script>

</body>
</html>
