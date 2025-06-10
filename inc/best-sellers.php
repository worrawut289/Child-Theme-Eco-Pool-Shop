<?php
function render_best_sellers() {
  ob_start();
  $args = [
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'meta_key'       => 'total_sales',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
  ];

  $loop = new WP_Query($args);
  if ($loop->have_posts()) :
    echo '<div class="product-grid">';
    while ($loop->have_posts()) : $loop->the_post();
      global $product;
      ?>
<div class="product-card">
    <a href="<?php the_permalink(); ?>">
        <?php echo $product->get_image(); ?>
        <h3 class="product-title"><?php the_title(); ?></h3>
    </a>
    <p class="product-price"><?php echo $product->get_price_html(); ?></p>
    <a href="<?= esc_url($product->add_to_cart_url()); ?>" class="btn-cart">
        <?= esc_html($product->add_to_cart_text()); ?>
    </a>
</div>
<?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
  endif;
  return ob_get_clean();
}

add_shortcode('best_sellers', 'render_best_sellers');