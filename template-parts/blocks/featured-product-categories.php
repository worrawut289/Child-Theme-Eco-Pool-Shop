<?php if (have_rows('repeater_product_categories')) : ?>
<div class="container">
    <div class="row g-4">

        <?php while (have_rows('repeater_product_categories')) : the_row(); 
                    $image = get_sub_field('image');
                    $name = get_sub_field('name');
                    $link = get_sub_field('link');
                ?>
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <div class="box-category-card">
                <a href="<?= esc_url($link); ?>" class="category-card">
                    <?php if ($image) : ?>
                    <img src="<?= esc_url($image['url']); ?>" alt="" class="category-image">
                    <i class="fa-solid fa-arrow-right category-icon"></i>
                    <h3 class="overlay-title"><?= esc_html($name); ?></h3>
                    <?php endif; ?>
                </a>
            </div>

        </div>
        <?php endwhile; ?>

    </div>
</div>
</div>


<?php endif; ?>