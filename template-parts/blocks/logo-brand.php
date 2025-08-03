<?php if (have_rows('reprater_logo_brand')) : ?>
<div class="container">
    <div class="row g-4">
        <div class="swiper brand-swiper">
            <div class="swiper-wrapper">
                <?php while (have_rows('reprater_logo_brand')) : the_row(); 
            $image = get_sub_field('logo');
        ?>
                <div class="swiper-slide text-center">
                    <?php if ($image) : ?>
                    <img src="<?= esc_url($image['url']); ?>" />
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.brand-swiper', {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 1800,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 3
            },
            768: {
                slidesPerView: 5
            },
            1024: {
                slidesPerView: 6
            }
        }
    });
});
</script>
<?php endif; ?>