@extends('Auth.layouts.master')

@section('content')
<div class="verify-email-container">
    <h2>تایید کد</h2>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <p>کد 4 رقمی ارسال شده به ایمیل خود را وارد کنید.</p>

    <form method="POST" action="{{ route('verification.verify-code') }}" class="verification-form">
        @csrf
        <div class="code-input">
            <input type="text" name="code" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" required>
        </div>
        <button type="submit">تایید کد</button>
    </form>

    <form method="POST" action="{{ route('verification.resend-code') }}" class="mt-4">
        @csrf
        <button type="submit" class="resend-button">ارسال مجدد کد</button>
    </form>
</div>

<style>
.verify-email-container {
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    text-align: center;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.verify-email-container h2 {
    margin-bottom: 20px;
    color: #333;
}

.verify-email-container p {
    margin-bottom: 15px;
    color: #666;
}

.verification-form {
    margin-top: 20px;
}

.code-input {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.code-input input {
    width: 150px;
    height: 50px;
    text-align: center;
    font-size: 24px;
    border: 2px solid #ddd;
    border-radius: 8px;
    outline: none;
    letter-spacing: 5px;
}

.code-inputs input:focus {
    border-color: var(--primary-color);
}

button {
    background-color: var(--primary-color);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: var(--secondary-color);
}

.resend-button {
    background-color: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.resend-button:hover {
    background-color: var(--primary-color);
    color: white;
}

.alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.code-inputs input');
    
    inputs.forEach((input, index) => {
        // Auto-focus next input
        input.addEventListener('input', function() {
            if (this.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Allow only numbers
        input.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
    });
});
</script>
