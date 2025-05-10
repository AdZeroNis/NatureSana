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
                    <p class="user-phone"><i class="fas fa-phone"></i> شماره تماس: {{ auth()->user()->phone }}</p>
                    @if(auth()->user()->address)
                        @if(auth()->user()->address->address_one)
                            <div class="info-row">
                                <p class="user-phone"><i class="fas fa-map-marker-alt"></i> آدرس 1: {{ auth()->user()->address->address_one }}</p>
                            </div>
                        @endif
                        @if(auth()->user()->address->address_two)
                            <div class="info-row">
                                <p class="user-phone"><i class="fas fa-map-marker-alt"></i> آدرس 2: {{ auth()->user()->address->address_two }}</p>
                            </div>
                        @endif
                    @endif
                        @if(auth()->user()->address && auth()->user()->address->address_three)
                            <div class="info-row">
                                <p class="user-phone"><i class="fas fa-map-marker-alt"></i> آدرس 3: {{ auth()->user()->address->address_three }}</p>
                            </div>
                            @endif  
                    <p class="user-join-date"><i class="fas fa-calendar-alt"></i> تاریخ عضویت: {{ \Morilog\Jalali\Jalalian::fromDateTime(auth()->user()->created_at)->format('Y/m/d') }}</p>
                    <a href="{{ route('edit.profile') }}" class="edit-btn">✏️ ویرایش پروفایل</a>
                </div>
            </div>
        </div>
    </div>
@endsection

