@extends('Auth.layouts.master')

@section('content')
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="profile-section">
            <!-- هدر پروفایل -->
            <div class="profile-header">
                <h2>👤 پروفایل کاربری</h2>
            </div>

            <!-- کارت پروفایل -->
            <div class="profile-card">

                <div class="profile-info">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p class="user-email"><i class="fas fa-envelope"></i> {{ auth()->user()->email }}</p>
                    <p class="user-join-date"><i class="fas fa-calendar-alt"></i> تاریخ عضویت: {{ \Morilog\Jalali\Jalalian::fromDateTime(auth()->user()->created_at)->format('Y/m/d') }}</p>
                    <a href="{{ route('edit.profile') }}" class="edit-btn">✏️ ویرایش پروفایل</a>
                </div>
            </div>
        </div>
    </div>
@endsection

