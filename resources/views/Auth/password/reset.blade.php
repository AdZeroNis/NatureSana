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
            <input type="password" name="password" placeholder="رمز عبور جدید" style="width: 100%;
    padding: 0.75rem;
    margin: 0.5rem 0;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-family: 'Vazir', sans-serif;
    font-size: 1rem;
    transition: border-color 0.3s ease;" >
        </div>
        <div class="form-group">
            <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور جدید" style="width: 100%;
    padding: 0.75rem;
    margin: 0.5rem 0;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-family: 'Vazir', sans-serif;
    font-size: 1rem;
    transition: border-color 0.3s ease;" >
        </div>
        <button type="submit">تغییر رمز عبور</button>
    </form>
</div>
@endsection
