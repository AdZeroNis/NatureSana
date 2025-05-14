<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')

    <section class="shop-section" id="shop">
        <div class="container">
            <h2 class="text-center mb-4">محصولات {{ $store->name }}</h2>
            
            <div class="product-grid">
                @forelse ($products as $product)
                    <div class="product-card">
                        <!-- نشانگر محصول جدید -->
                        @if($product->created_at->diffInDays() < 7)
                            <div class="product-badge position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger py-2">جدید</span>
                            </div>
                        @endif
                        
                        <!-- نشانگر محصول از فروشگاه همکار -->
                        @if($product->store_id !== $store->id)
                            <div class="product-badge position-absolute top-0 end-0 m-2">
                                <span class="badge bg-info py-2">از فروشگاه {{ $product->store->name }}</span>
                            </div>
                        @endif
                        
                        <a href="{{ asset('AdminAssets/Product-image/' . $product->image) }}" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                            <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        </a>
                        
                        <div class="product-info">
                            <h3>{{ Str::limit($product->name, 30) }}</h3>
                            <p class="price">{{ number_format($product->price) }} تومان</p>
                            <form action="{{ route('product.show', $product->id) }}" method="GET">
                                <button type="submit" class="view-btn">مشاهده</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>محصولی یافت نشد.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('Home.layouts.footer')
</body>
</html>
