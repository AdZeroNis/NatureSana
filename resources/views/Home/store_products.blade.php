<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')

<!-- بخش محصولات -->
<section class="shop-section" id="shop">
    <h2>محصولات</h2>
    <div class="product-grid">
        @foreach ($products as $product)
            @if ($product->status == 1)
                <div class="product-card">
                    <!-- نشانگر محصول جدید -->
                    @if($product->created_at->diffInDays() < 7)
                        <div class="product-badge position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger py-2">جدید</span>
                        </div>
                    @endif
                    <a href="{{ asset('AdminAssets/Product-image/' . $product->image) }}" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                        <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                    </a>
                    <h3>{{ Str::limit($product->name, 30) }}</h3>
                    <p>{{ number_format($product->price) }} تومان</p>
                    <form action="{{ route('product.show', $product->id) }}" method="GET">
                        <button type="submit">مشاهده</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
</section>


@include('Home.layouts.footer')

  
</body>
</html>
