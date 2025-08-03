<?php
function render_latest_products() {
  ob_start();

  // Query สินค้าใหม่ล่าสุด
  $args = [
    'post_type'      => 'product',
    'posts_per_page' => 15,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false,
  ];

  $loop = new WP_Query($args);
  if ($loop->have_posts()) : ?>

<!-- Swiper wrapper -->
<div class="swiper latest-products-swiper">
    <div class="swiper-wrapper">
        <?php while ($loop->have_posts()) : $loop->the_post(); global $product; ?>
        <div class="swiper-slide">
            <div class="product-card text-center">
                <a href="<?php the_permalink(); ?>">
                    <?php echo $product->get_image(); ?>
                    <h3 class="product-title"><?php the_title(); ?></h3>
                </a>
                <p class="product-price"><?php echo $product->get_price_html(); ?></p>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Optional navigation -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.latest-products-swiper', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 5,
            }
        }
    });
});
</script>

<?php
  wp_reset_postdata();
  endif;

  return ob_get_clean();
}
add_shortcode('latest_products', 'render_latest_products');