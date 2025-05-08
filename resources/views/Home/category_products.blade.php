<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')
<a href="#" class="text-decoration-none">
    <div class="container-fluid mt-2">
        <div class="top-banner rounded-3 overflow-hidden">
            <img src="{{ asset('path/to/your/banner-image.jpg') }}" alt="تبلیغ" class="img-fluid w-100" style="height: 150px; object-fit: cover;">
        </div>
    </div>
</a>

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

                    <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
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

    @include('Home.layouts.footer')
</body>
</html>
