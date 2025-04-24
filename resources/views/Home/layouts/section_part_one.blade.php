<!-- Add Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('css/slider.css') }}" />

<section class="hero">
    <!-- Slider main container -->
    <div class="swiper hero-slider">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
                <div class="slide-content">
                    <h1>گیاهان دارویی را کشف کنید</h1>
                    <p>منبع معتبر شما برای سلامتی و زیبایی طبیعی</p>
                </div>
                <img src="https://images.unsplash.com/photo-1515433860798-7ed3a82b80b1" alt="گیاهان دارویی 1">
            </div>
            <div class="swiper-slide">
                <div class="slide-content">
                <h1>گیاهان دارویی را کشف کنید</h1>
                <p>منبع معتبر شما برای سلامتی و زیبایی طبیعی</p>
                </div>
                <img src="https://images.unsplash.com/photo-1598052062264-0e63e9bad4ab" alt="گیاهان دارویی 2">
            </div>
        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- Pagination dots -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Add Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@include('Home.layouts.js')