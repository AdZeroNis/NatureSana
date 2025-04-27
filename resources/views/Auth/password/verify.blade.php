@extends('Auth.layouts.master')

@section('content')
<div class="auth-container">
    <h2>تایید کد</h2>
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
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
    <form action="{{ route('password.verify') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="code-inputs">
            <input type="text" name="code" maxlength="6" placeholder="کد تایید را وارد کنید" required>
        </div>
        <button type="submit">تایید کد</button>
    </form>
    <div class="auth-links">
        <a href="{{ route('password.request') }}">ارسال مجدد کد</a>
        <a href="{{ route('login') }}">بازگشت به صفحه ورود</a>
    </div>
</div>

<style>
.code-inputs {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.code-inputs input {
    width: 200px;
    text-align: center;
    font-size: 1.2rem;
    letter-spacing: 0.5rem;
}
</style>
@endsection
