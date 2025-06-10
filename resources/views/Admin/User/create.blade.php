@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="add-user">
    <h2>افزودن کاربر جدید</h2>
    <div class="card">
        <form method="POST" action="{{ route('panel.user.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="name">نام</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
    <label for="phone">شماره تلفن</label>
    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
    @error('phone')
        <span class="error">{{ $message }}</span>
    @enderror
</div>

                <div class="form-group">
                    <label for="email">ایمیل</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">رمز عبور</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">تکرار رمز عبور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="form-actions" >
                <button type="submit" class="btn btn-submit">ذخیره کاربر</button>
                <a href="{{ route('panel.user.index') }}" class="btn btn-cancel">لغو</a>
            </div>
        </form>
    </div>
</section>
@endsection
