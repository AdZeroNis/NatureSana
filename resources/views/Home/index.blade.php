@extends('Home.layouts.master')

@section('content')

<section class="shop-section" id="shop">
    <h2>محصولات</h2>
    <div class="product-grid">
        @foreach ($latestItems['products'] as $index => $product)
            <div class="product-card {{ $index >= 8 ? 'extra-product d-none' : '' }}">
                <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>{{ number_format($product->price, 0) }} تومان</p>
                <form action="{{ route('product.show', $product->id) }}" method="GET">
                    <button type="submit">مشاهده</button>
                </form>
            </div>
        @endforeach
    </div>

  @if(count($latestItems['products']) >= 8)
    <a href="{{ url()->current() }}?all=1" id="showAllProductsBtn" class="btn btn-primary mt-3">مشاهده همه</a>
@endif

</section>
<section class="shop-section" id="shop">
    <h2>مقالات</h2>
    <div class="product-grid">
        @foreach ($latestItems['articles'] as $index => $article)
            <div class="product-card {{ $index >= 8 ? 'extra-product d-none' : '' }}">
                <img src="{{ asset('AdminAssets/Article-image/' . $article->image) }}" alt="{{ $article->title }}">
                <h3>{{ $article->title }}</h3>
                <form action="{{ route('article.show', $article->id) }}" method="GET">
                    <button type="submit">مشاهده</button>
                </form>
            </div>
        @endforeach
    </div>

  @if(count($latestItems['articles']) >= 8)
    <a href="{{ url()->current() }}?all=1" id="showAllProductsBtn" class="btn btn-primary mt-3">مشاهده همه</a>
@endif

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
