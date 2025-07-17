@extends('Auth.layouts.master')

@section('content')
<div class="auth-container">
    <h2>بازیابی رمز عبور</h2>

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="email" placeholder="ایمیل خود را وارد کنید" style=" width: 100%;
    padding: 0.75rem;
    margin: 0.5rem 0;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-family: 'Vazir', sans-serif;
    font-size: 1rem;
    transition: border-color 0.3s ease;" >
            @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
        </div>
        <button type="submit">ارسال کد تایید</button>
    </form>
    <div class="auth-links">
        <a href="{{ route('login') }}">بازگشت به صفحه ورود</a>
    </div>
</div>
@endsection
