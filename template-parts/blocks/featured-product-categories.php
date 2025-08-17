<?php 
$unique_id = 'categorySwiper_' . uniqid();
?>

<div class="container">
    <div class="featured-categories-swiper">
        <!-- Swiper -->
        <div class="swiper <?php echo $unique_id; ?>">
            <div class="swiper-wrapper">
                <?php if (have_rows('repeater_product_categories')) : ?>
                <?php while (have_rows('repeater_product_categories')) : the_row(); 
                        $image = get_sub_field('image');
                        $name = get_sub_field('name');
                        $name_en = get_sub_field('name_en');
                        $link = get_sub_field('link');
                    ?>
                <div class="swiper-slide">
                    <div class="box-category-card">
                        <a href="<?= esc_url($link); ?>" class="category-card">
                            <?php if ($image) : ?>
                            <img src="<?= esc_url($image['url']); ?>" alt="" class="category-image">

                            <h3 class="overlay-title"><?= esc_html($name); ?></h3>
                            <h4 class="overlay-title-en"><?= esc_html($name_en); ?></h4>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination pagination-<?php echo $unique_id; ?>"></div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next next-<?php echo $unique_id; ?>"></div>
            <div class="swiper-button-prev prev-<?php echo $unique_id; ?>"></div>

        </div>
    </div>
</div>

<script>
(function() {
    const uniqueClass = '<?php echo $unique_id; ?>';

    function initSwiper() {
        const swiperElement = document.querySelector('.' + uniqueClass);

        // ตรวจสอบว่าได้ initialize ไปแล้วหรือยัง
        if (swiperElement && !swiperElement.hasAttribute('data-swiper-initialized')) {
            swiperElement.setAttribute('data-swiper-initialized', 'true');

            const categorySwiper = new Swiper('.' + uniqueClass, {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: false,
                pagination: {
                    el: '.pagination-' + uniqueClass,
                    clickable: true,
                    type: 'bullets',
                },
                navigation: {
                    nextEl: '.next-' + uniqueClass,
                    prevEl: '.prev-' + uniqueClass,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 40,
                    },
                },
                on: {
                    slideChange: function() {
                        this.pagination.update();
                    },
                    reachEnd: function() {
                        this.pagination.update();
                    },
                    reachBeginning: function() {
                        this.pagination.update();
                    },
                    touchEnd: function() {
                        setTimeout(() => {
                            this.pagination.update();
                        }, 50);
                    }
                }
            });
        }
    }

    // ตรวจสอบว่า DOM พร้อมแล้วหรือยัง
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSwiper);
    } else {
        initSwiper();
    }
})();
</script>