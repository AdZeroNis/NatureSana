@extends('Admin.layouts.master')

@section("content")

<section class="dashboard" id="dashboard">
    <div class="cards-containerr gap-4">
        <div class="cardd products-cardd">
            <h3>کل محصولات</h3>
            <p>{{ $productsCount }}</p>
        </div>
        <div class="cardd stores-cardd">
            <h3>کل مغازه‌ها</h3>
            <p>{{ $storesCount }}</p>
        </div>
        <div class="cardd articles-cardd">
            <h3>کل مقالات</h3>
            <p>{{ $articlesCount }}</p>
        </div>
        @if($user->role === 'super_admin')
        <div class="cardd users-cardd">
            <h3>کاربران ثبت‌نام‌شده</h3>
            <p>{{ $usersCount }}</p>
        </div>
        @endif
    </div>



</section>


@endsection
