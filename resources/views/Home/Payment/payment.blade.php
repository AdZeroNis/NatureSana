<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>درگاه پرداخت</title>
    <style>
        :root {
            --main-color: #0059b3;
            --main-hover: #004080;
            --border-color: #d1d5db;
            --error-color: #e03e3e;
            --success-color: #2e7d32;
            --bg-color: #f8f9fa;
            --font-family: "Tahoma", sans-serif;
        }

        body {
            margin: 0;
            background: var(--bg-color);
            font-family: var(--font-family);
            color: #212529;
            direction: rtl;
        }

        .payment-wrapper {
            max-width: 450px;
            margin: 3rem auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        h2 {
            text-align: center;
            color: var(--main-color);
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .order-summary {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            background: #f0f4ff;
        }

        .order-summary p {
            margin: 0.3rem 0;
            font-size: 1rem;
        }

        .order-summary .total {
            font-weight: 700;
            color: var(--main-color);
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            font-size: 0.95rem;
            display: block;
        }

        input[type="text"], input[type="password"] {
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
            font-family: var(--font-family);
        }

        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: var(--main-color);
            background-color: #fff;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            flex-wrap: nowrap;
        }

        .form-row > div {
            flex: 1;
        }

        .submit-btn {
            background-color: var(--main-color);
            border: none;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 25px;
            padding: 0.85rem 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: var(--main-hover);
        }

        /* لوگوهای بانک‌ها */
        .bank-logos {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .bank-logos img {
            height: 40px;
            filter: grayscale(100%);
            transition: filter 0.3s ease;
            cursor: default;
        }

        .bank-logos img:hover {
            filter: none;
        }

        /* پیغام موفقیت یا خطا */
        .message {
            padding: 0.8rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .message.success {
            background-color: #d4edda;
            color: var(--success-color);
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: var(--error-color);
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 500px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="payment-wrapper">
        <h2>درگاه پرداخت اینترنتی</h2>

        <div class="order-summary">
            <p>آدرس تحویل: <strong>{{ $address }}</strong></p>
            <p class="total">جمع کل: <strong>{{ number_format($totalPrice) }} تومان</strong></p>
        </div>

        {{-- پیام خطا یا موفقیت اینجا اگر داری --}}
        @if(session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('payment.submit') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="address" value="{{ $address }}">

            <label for="card-number">شماره کارت</label>
            <input type="text" id="card-number" name="card_number" maxlength="16" pattern="\d{16}" placeholder="xxxx xxxx xxxx xxxx" required autofocus>

            <div class="form-row">
                <div>
                    <label for="expiry-date">تاریخ انقضا</label>
                    <input type="text" id="expiry-date" name="expiry_date" maxlength="5" pattern="(0[1-9]|1[0-2])\/\d{2}" placeholder="MM/YY" required>
                </div>
                <div>
                    <label for="cvv">CVV2</label>
                    <input type="password" id="cvv" name="cvv" maxlength="4" pattern="\d{3,4}" placeholder="xxx" required>
                </div>
            </div>

            <button type="submit" class="submit-btn">پرداخت</button>
        </form>
    </div>
</body>

</html>
