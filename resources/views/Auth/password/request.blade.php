@extends('Auth.layouts.master')

@section('content')
<div class="auth-container">
    <h2>بازیابی رمز عبور</h2>
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
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="email" name="email" placeholder="ایمیل خود را وارد کنید" required>
        </div>
        <button type="submit">ارسال کد تایید</button>
    </form>
    <div class="auth-links">
        <a href="{{ route('login') }}">بازگشت به صفحه ورود</a>
    </div>
</div>
@endsection
