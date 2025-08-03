<?php 
$unique_id = 'bestsellerSwiper_' . uniqid();

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 10,
    'product_cat' => 'best-seller',
    'order'          => 'DESC',
);

$loop = new WP_Query($args);
?>

<div class="container">
    <div class="featured-categories-swiper">
        <!-- Swiper -->
        <div class="swiper <?php echo $unique_id; ?>">
            <div class="swiper-wrapper">
                <?php if ($loop->have_posts()) : ?>
                <?php while ($loop->have_posts()) : $loop->the_post(); 
                        global $product;
                    ?>
                <div class="swiper-slide">
                    <div class="box-best-seller-card">
                        <a href="<?php the_permalink(); ?>" class="best-seller-card">
                            <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', array('class' => 'best-seller-image')); ?>
                            <h3 class="best-seller-title"><?php the_title(); ?></h3>
                            <h4 class="best-seller-price"><?php echo $product->get_price_html(); ?></h4>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
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