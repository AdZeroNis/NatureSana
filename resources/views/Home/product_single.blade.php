<!DOCTYPE html>
<html lang="en">
    @include('Home.layouts.head')
<body>
    @include('Home.layouts.header')

<section class="single-product-section">
    <div class="container">
        <div class="product-header">
            <h1>{{ $product->name }}</h1>
        </div>

        <div class="product-details">
            <div class="product-image">
                @if($product->image)
                <a href="{{ asset('AdminAssets/Product-image/' . $product->image) }}" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                        <img src="{{ asset('AdminAssets/Product-image/' . $product->image) }}" alt="{{ $product->name }}">
                    </a>
                @else
                    <div class="no-image">
                        <i class="fas fa-box"></i>
                    </div>
                @endif
            </div>

            <div class="product-info">
                <div class="info-row">
                    <span class="label"><i class="fas fa-tag"></i> قیمت:</span>
                    <span class="value">{{ number_format($product->price, 0) }} تومان</span>
                </div>
                <div class="info-row">
                    <span class="label"><i class="fas fa-folder"></i> دسته‌بندی:</span>
                    <span class="value">{{ $product->category ? $product->category->name : 'بدون دسته‌بندی' }}</span>
                </div>
                <div class="info-row">
                    <span class="label"><i class="fas fa-store"></i> فروشگاه:</span>
                    <span class="value">{{ $product->store ? $product->store->name : 'بدون فروشگاه' }}</span>
                </div>

                <div class="info-row">
                    <span class="label"><i class="fas fa-align-right"></i> توضیحات:</span>
                    <span class="value">{{ $product->description ?: 'بدون توضیحات' }}</span>
                </div>
                <form action="" method="POST" class="add-to-cart-form">
                    @csrf
                    <button type="submit" class="add-to-cart-btn">افزودن به سبد خرید</button>
                </form>
            </div>
        </div>
    </div>
</section>

@include('Home.layouts.footer')

<style>
.single-product-section {
    padding: 3rem 0;
    background: linear-gradient(180deg, var(--light-bg) 80%, #fff 100%);
    direction: rtl; /* جهت راست به چپ */
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.product-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 15px;
    color: white;
}

.product-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.8rem;
    margin: 0;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
}

.product-details {
    display: flex;
    gap: 3rem;
    margin-bottom: 3rem;
}

.product-image {
    flex: 1;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-radius: 15px;
}

.product-image img {
    width: 100%;
    max-height: 450px;
    object-fit: cover;
    border-radius: 15px;
    transition: transform 0.3s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.product-image img:hover {
    transform: scale(1.05);
}

.no-image {
    width: 100%;
    height: 250px;
    background: linear-gradient(135deg, #e9ecef, #dfe4ea);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
}

.no-image i {
    font-size: 5rem;
    color: #adb5bd;
    opacity: 0.7;
}

.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
    background: #f9f9f9;
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.info-row {
    display: flex;
    align-items: center;
    gap: 1.2rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #e0e0e0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-weight: bold;
    color: var(--primary-color);
    flex: 0 0 130px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
}

.info-row .label i {
    color: var(--accent-color);
    font-size: 1.2rem;
}

.info-row .value {
    color: var(--text-color);
    font-size: 1.1rem;
    line-height: 1.6;
}

.add-to-cart-form {
    margin-top: 1.5rem;
    text-align: center;
}

.add-to-cart-btn {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 0.9rem 2.5rem;
    border-radius: 30px;
    cursor: pointer;
    font-family: 'Arial', sans-serif;
    font-size: 1.1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(216, 27, 96, 0.3);
    position: relative;
    overflow: hidden;
}

.add-to-cart-btn:hover {
    background: var(--secondary-color);
    box-shadow: 0 6px 20px rgba(67, 160, 71, 0.4);
    transform: translateY(-3px);
}

.add-to-cart-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: 0.5s;
}

.add-to-cart-btn:hover::before {
    left: 100%;
}

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
        border-radius: 10px;
    }

    .product-header h1 {
        font-size: 2.2rem;
    }

    .product-details {
        flex-direction: column;
        gap: 1.5rem;
    }

    .product-image img {
        max-height: 350px;
    }

    .product-info {
        padding: 1rem;
    }

    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .info-row .label {
        flex: none;
        font-size: 1rem;
    }

    .info-row .value {
        font-size: 1rem;
    }

    .add-to-cart-btn {
        padding: 0.7rem 2rem;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .product-header h1 {
        font-size: 1.8rem;
    }

    .product-image img {
        max-height: 300px;
    }

    .product-info {
        padding: 0.8rem;
    }
}
</style>
</body>
</html>