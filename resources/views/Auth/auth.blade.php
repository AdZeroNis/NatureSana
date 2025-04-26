@extends('Auth.layouts.master')

@section('content')
<div class="auth-container">
         <div class="auth-toggle">
            <button class="active" onclick="showLogin()">ورود</button>
            <button onclick="showRegister()">ثبت‌نام</button>
        </div>

        <div class="auth-form login active">
            <h2>ورود به حساب کاربری</h2>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="ایمیل" required>
                <input type="password" name="password" placeholder="رمز عبور" required>
                <button type="submit">ورود</button>
                <div class="forgot-password">
                    <a href="">رمز عبور خود را فراموش کرده‌اید؟</a>
                </div>
            </form>
        </div>

        <div class="auth-form register">
            <h2>ثبت‌نام</h2>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="نام کامل" required>
                <input type="email" name="email" placeholder="ایمیل" required>
                <input type="tel" name="phone" placeholder="شماره تماس" required>
                <input type="text" name="address" placeholder="آدرس" required>
                <input type="password" name="password" placeholder="رمز عبور" required>
                <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور" required>
                <button type="submit">ثبت‌نام</button>
            </form>
        </div>
  </div>
</div>
@endsection
