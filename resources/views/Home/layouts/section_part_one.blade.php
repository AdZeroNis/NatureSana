<!-- Add Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('css/slider.css') }}" />

<section class="hero">
    <!-- Slider main container -->
    <div class="swiper hero-slider">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($latestItems['sliders'] as $slider)
                <div class="swiper-slide">
                    <div class="slide-content">
                        <h1>{{ $slider->title }}</h1>
                        <p>{{ $slider->description }}</p>
                    </div>
                    <img src="{{ asset('AdminAssets/Slider-image/' . $slider->image) }}" alt="{{ $slider->title }}">
                </div>
            @endforeach
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