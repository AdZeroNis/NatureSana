<!DOCTYPE html>
<html lang="en">

<body>


<section class="payment-section">
    <h2>پرداخت</h2>

    <div class="payment-container">
        <div class="order-summary">
            <h3>خلاصه سفارش</h3>
            <p>آدرس تحویل: {{ $address }}</p>

            <p class="total">جمع کل: {{ number_format($totalPrice, 0) }} تومان</p>
        </div>

        <div class="payment-form">
            <form action="{{ route('payment.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="address" value="{{ $address }}">

                <div class="form-group">
                    <label for="card-number">شماره کارت</label>
                    <input type="text" id="card-number" name="card-number" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry-date">تاریخ انقضا</label>
                        <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" required>
                    </div>

                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>
                </div>

                <button type="submit" class="submit-payment-btn">پرداخت</button>
            </form>
        </div>
    </div>
</section>


</body>
<style>
.payment-section {
    max-width: 1300px;
    margin: 3rem auto;
    padding: 0 1.5rem;
    direction: rtl;
}

.payment-container {
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
    gap: 1rem;
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

.order-summary .total {
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--accent-color);
}

.payment-form {
    flex: 2;
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    font-family: 'Arial', sans-serif;
    font-size: 1rem;
    color: var(--text-color);
    display: block;
    margin-bottom: 0.5rem;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-family: 'Arial', sans-serif;
    font-size: 0.9rem;
    color: var(--text-color);
    background: #f9f9f9;
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: var(--accent-color);
    background: white;
}

.form-group input::placeholder {
    color: #aaa;
}

.form-row {
    display: flex;
    gap: 1rem;
}

.form-row .form-group {
    flex: 1;
}

.submit-payment-btn {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    cursor: pointer;
    font-family: 'Arial', sans-serif;
    font-size: 1rem;
    transition: background 0.3s ease;
    width: 100%;
    text-align: center;
}

.submit-payment-btn:hover {
    background: var(--secondary-color);
}

@media (max-width: 1024px) {
    .payment-container {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .order-summary h3 {
        font-size: 1.1rem;
    }

    .order-summary p {
        font-size: 0.9rem;
    }

    .order-summary .total {
        font-size: 1rem;
    }

    .form-group label {
        font-size: 0.9rem;
    }

    .form-group input {
        font-size: 0.8rem;
        padding: 0.6rem;
    }

    .submit-payment-btn {
        font-size: 0.9rem;
        padding: 0.6rem 1.5rem;
    }
}

@media (max-width: 480px) {
    .payment-section {
        padding: 0 1rem;
    }

    .form-row {
        flex-direction: column;
        gap: 0.5rem;
    }

    .order-summary, .payment-form {
        padding: 1rem;
    }
}
</style>
</html>
