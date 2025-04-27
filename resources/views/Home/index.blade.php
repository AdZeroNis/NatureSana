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
                <form action="" method="POST">
                    @csrf
                    <button type="submit">افزودن به سبد خرید</button>
                </form>
            </div>
        @endforeach
    </div>
</section>

<section class="stores-section" id="stores">
    <h2>فروشگاه‌های ما</h2>
    <div class="store-grid">
        @foreach ($latestItems['stores'] as $store)
            <div class="store-card">
                <a href="">
                    <img src="{{ asset('AdminAssets/Store-image/' . $store->image) }}" alt="{{ $store->name }}">
                </a>
                <h3>{{ $store->name }}</h3>
            </div>
        @endforeach
    </div>
</section>

<style>
.shop-section, .stores-section {
    max-width: 1300px;
    margin: 3rem auto;
    padding: 0 1.5rem;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    direction: rtl; /* ترتیب از راست به چپ */
}

.store-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.2rem; /* فاصله‌ی کمتر */
    direction: rtl; /* ترتیب از راست به چپ */
}

.product-card {
    background: white;
    border-radius: 15px;
    padding: 1rem;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    direction: rtl; /* تنظیم جهت متن داخل کارت */
}

.store-card {
    padding: 0.5rem; /* کمتر از محصول */
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    max-width: 150px; /* کارت عرضش محدود بشه */
    margin: 0 auto; /* وسط چین */
    direction: rtl; /* تنظیم جهت متن داخل کارت */
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 0.75rem;
}

.store-card img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 50%; /* تصویر گرد */
    margin: 0 auto 0.5rem;
    display: block;
}

.product-card h3, .store-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    margin: 0.5rem 0;
    color: var(--text-color);
}

.store-card h3 {
    font-size: 0.95rem;
    margin: 0.3rem 0;
}

.product-card p {
    font-size: 1rem;
    color: var(--text-color);
    margin-bottom: 0.75rem;
}

.product-card button {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    cursor: pointer;
    font-family: 'Arial', sans-serif;
    font-size: 0.9rem;
    transition: background 0.3s ease;
}

.product-card button:hover {
    background: var(--secondary-color);
}

@media (max-width: 1024px) {
    .product-grid, .store-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .product-grid, .store-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .product-card img, .store-card img {
        height: 70px;
        width: 70px;
    }

    .product-card h3, .store-card h3 {
        font-size: 1rem;
    }

    .product-card p {
        font-size: 0.9rem;
    }

    .product-card button {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .product-grid, .store-grid {
        grid-template-columns: 1fr;
    }

    .product-card img, .store-card img {
        height: 70px;
        width: 70px;
    }
}
</style>
@endsection