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


