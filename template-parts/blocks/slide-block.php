<?php if (have_rows('repeater_slides')) : ?>

<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <?php while (have_rows('repeater_slides')) : the_row(); ?>
        <?php $image = get_sub_field('image'); ?>
        <div class="swiper-slide">
            <?php if ($image) : ?>
            <img src="<?= esc_url($image['url']); ?>" alt="">
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>

    <div class="swiper-pagination"></div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.mySwiper', {
        spaceBetween: 10,
        autoplay: {
            delay: 2500, // เวลาเปลี่ยนสไลด์ (มิลลิวินาที)
            disableOnInteraction: false // ให้เล่นต่อหลังจาก user แตะ
        },
        loop: true, // วนลูปต่อเนื่อง
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

});
</script>
<?php endif; ?>