<!-- Add Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('css/slider.css') }}" />


    <!-- Slider main container -->
    <div class="swiper hero-slider">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($latestItems['sliders'] as $slider)
                <div class="swiper-slide">
                    <a href="{{ $slider->url }}" target="_blank">
                        <img src="{{ asset('AdminAssets/Slider-image/' . $slider->image) }}" alt="Slider Image">
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- Pagination dots -->
        <div class="swiper-pagination"></div>
    </div>


<!-- Add Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@include('Home.layouts.js')