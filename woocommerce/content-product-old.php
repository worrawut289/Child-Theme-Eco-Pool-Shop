<?php
defined('ABSPATH') || exit;
global $product;
?>

<div class="card h-100 shadow-sm">
    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
        <div class="ratio ratio-4x3">
            <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'card-img-top object-fit-cover']); ?>
        </div>
    </a>

    <div class="card-body">
        <h5 class="card-title"><?php the_title(); ?></h5>
        <p class="card-text text-primary fw-bold"><?php echo $product->get_price_html(); ?></p>
    </div>

    <div class="card-footer bg-white border-0 d-flex justify-content-between">
        <a href="<?php the_permalink(); ?>" class="btn btn-outline-secondary btn-sm">ดูรายละเอียด</a>
        <a href="<?= esc_url($product->add_to_cart_url()); ?>" class="btn btn-success btn-sm">
            <?= esc_html($product->add_to_cart_text()); ?>
        </a>
    </div>
</div>