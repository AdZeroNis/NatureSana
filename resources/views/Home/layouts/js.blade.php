<script>
    document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper('.hero-slider', {
        // Optional parameters
        loop: true,
        effect: 'fade',
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
        // Pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});
</script>
