@extends('Home.layouts.master')

@section('content')

<section class="shop-section" id="shop">
    <h2>محصولات</h2>
    <div class="product-grid">
        @foreach ($latestProducts as $product)
            <div class="product-card">
                <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>${{ number_format($product->price, 2) }}</p>
                <form action="" method="POST">
                    @csrf
                    <button type="submit">افزودن به سبد خرید</button>
                </form>
            </div>
        @endforeach
    </div>
</section>

<section class="blog-section" id="blog">
    <h2>مقالات ما</h2>
    <div class="blog-post">
        <h3>The Benefits of Echinacea</h3>
        <p>Echinacea has been used for centuries to boost immunity and fight infections...</p>
        <a href="#">Read More</a>
    </div>
    <div class="blog-post">
        <h3>Growing Your Own Medicinal Herbs</h3>
        <p>Learn how to cultivate your own herbal garden with our expert tips...</p>
        <a href="#">Read More</a>
    </div>
</section>

@endsection
