@extends('Admin.layouts.master')

@section("content")

<section class="dashboard" id="dashboard">
    <div class="card">
        <h3>کل محصولات</h3>
        <p>{{ $productsCount }}</p>
    </div>
    <div class="card">
        <h3>کل مغازه</h3>
        <p>{{ $storesCount }}</p>
    </div>
    <div class="card">
        <h3>کل مقالات</h3>
        <p>{{ $articlesCount }}</p>
    </div>
    @if($user->role === 'super_admin')
    <div class="card">
        <h3>کاربران ثبت‌نام‌شده</h3>
        <p>{{ $usersCount }}</p>
    </div>
    @endif
</section>
@endsection
