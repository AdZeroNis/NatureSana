@extends('Home.layouts.master')

@section('content')
<section class="shop-section" id="shop">
        <h2>محصولات ویژه ما</h2>
        <div class="product-grid">
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1515433860798-7ed3a82b80b1" alt="Echinacea">
                <h3>Echinacea</h3>
                <p>$19.99</p>
                <button>افزودن به سبد خرید</button>
            </div>
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1598052062264-0e63e9bad4ab" alt="Ginger Root">
                <h3>Ginger Root</h3>
                <p>$14.99</p>
                <button>افزودن به سبد خرید</button>
            </div>
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1628253747506-3873b706a008" alt="Ashwagandha">
                <h3>Ashwagandha</h3>
                <p>$24.99</p>
                <button>افزودن به سبد خرید</button>
            </div>
        </div>
    </section>
    <section class="blog-section" id="blog">
        <h2>Explore Medicinal Wisdom</h2>
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
