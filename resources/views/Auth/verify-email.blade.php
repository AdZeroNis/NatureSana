@extends('Auth.layouts.master')

@section('content')
<div class="verify-email-container">
    <h2>تایید ایمیل</h2>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <p>لطفاً ایمیل خود را برای ادامه تایید کنید.</p>
    <p>اگر ایمیل تایید را دریافت نکرده‌اید، می‌توانید درخواست ارسال مجدد کنید.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">ارسال مجدد ایمیل تایید</button>
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

.verify-email-container button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.verify-email-container button:hover {
    background-color: #45a049;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert-success {
    background-color: #dff0d8;
    border-color: #d6e9c6;
    color: #3c763d;
}
</style>
@endsection
