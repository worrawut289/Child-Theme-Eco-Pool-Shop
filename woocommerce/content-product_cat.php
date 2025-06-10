<?php
defined( 'ABSPATH' ) || exit;
global $woocommerce_loop;

$category_link = get_term_link( $category );
$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
$image = wp_get_attachment_image_url( $thumbnail_id, 'woocommerce_thumbnail' );
?>

<div class="card-content-product-cat h-100 shadow-sm">
    <a href="<?= esc_url($category_link); ?>" class="text-decoration-none">
        <?php if ( $image ) : ?>
        <img src="<?= esc_url($image); ?>" class="card-img-top" alt="<?= esc_attr($category->name); ?>">
        <?php endif; ?>
    </a>
    <div class="card-body-content-product-cat">
        <h5 class="card-title"><?= esc_html($category->name); ?></h5>
        <p class="card-text text-muted small"><?= esc_html($category->count); ?> รายการ</p>

        <?php
    // Optional: แสดง ACF field เช่น short_description
    $desc = get_field('short_desc', 'product_cat_' . $category->term_id);
    if ($desc) {
      echo '<p class="small text-muted mb-2">' . esc_html($desc) . '</p>';
    }
    ?>

        <!-- <a href="<?= esc_url($category_link); ?>" class="btn btn-outline-primary btn-sm">ดูสินค้า</a> -->
    </div>
</div>