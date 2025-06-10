@extends('Home.layouts.master')

@section('content')

<section class="shop-section" id="shop">
    <h2>محصولات</h2>
    <div class="product-grid">
        @foreach ($latestItems['products'] as $product)
            <div class="product-card">
                <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>{{ number_format($product->price, 0) }} تومان</p>
                <form action="{{ route('product.show', $product->id) }}" method="GET">
                    <button type="submit">مشاهده</button>
                </form>
            </div>
        @endforeach
    </div>
</section>

<section class="stores-section" id="stores">
    <h2>فروشگاه‌های ما</h2>
    <div class="store-grid">
        @foreach ($latestItems['stores'] as $store)
            <a href="{{ route('store.products', $store->id) }}" class="store-avatar">
                <img src="{{ asset('AdminAssets/Store-image/' . $store->image) }}" alt="{{ $store->name }}">
                <h3>{{ $store->name }}</h3>
            </a>
        @endforeach
    </div>
</section>


@endsection
