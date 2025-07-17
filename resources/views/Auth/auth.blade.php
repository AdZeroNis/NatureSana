@extends('Auth.layouts.master')

@section('content')
<div class="auth-container">
         <div class="auth-toggle">
            <button class="active" onclick="showLogin()">ورود</button>
            <button onclick="showRegister()">ثبت‌نام</button>
        </div>

        <div class="auth-form login active">
            <h2>ورود به حساب کاربری</h2>
            @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <input type="text" name="email" placeholder="ایمیل"  autocomplete="off" >
                @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                <input type="password" name="password" placeholder="رمز عبور"  autocomplete="off" >
                @error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                <button type="submit">ورود</button>
                <div class="auth-links">
                    <a href="{{ route('password.request') }}">فراموشی رمز عبور</a>
                </div>
            </form>
        </div>

        <div class="auth-form register">
            <h2>ثبت‌نام</h2>
            
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="نام کامل"   autocomplete="off">
@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<input type="text" name="email" placeholder="ایمیل"  autocomplete="off">
@error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<input type="tel" name="phone" placeholder="شماره تماس"  autocomplete="off">
@error('phone')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<input type="password" name="password" placeholder="رمز عبور" >
@error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

                <button type="submit">ثبت‌نام</button>
            </form>
        </div>
  </div>
</div>
@endsection
