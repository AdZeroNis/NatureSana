@extends('Auth.layouts.master')

@section('content')
<div class="auth-container">
    <h2>تغییر رمز عبور</h2>
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
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <input type="password" name="password" placeholder="رمز عبور جدید" required>
        </div>
        <div class="form-group">
            <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور جدید" required>
        </div>
        <button type="submit">تغییر رمز عبور</button>
    </form>
</div>
@endsection
