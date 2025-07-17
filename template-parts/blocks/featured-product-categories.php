<div class="container">
    <div class="row g-4">
        <div class="grid-category">
            <?php if (have_rows('repeater_product_categories')) : ?>
            <?php while (have_rows('repeater_product_categories')) : the_row(); 
                    $image = get_sub_field('image');
                    $name = get_sub_field('name');
                    $name_en = get_sub_field('name_en');
                    $link = get_sub_field('link');
                ?>
            <div class="box-category-card">
                <a href="<?= esc_url($link); ?>" class="category-card">
                    <?php if ($image) : ?>
                    <img src="<?= esc_url($image['url']); ?>" alt="" class="category-image">
                    <i class="fa-solid fa-arrow-right category-icon"></i>
                    <h3 class="overlay-title"><?= esc_html($name); ?></h3>
                    <h3 class="overlay-title-en"><?= esc_html($name_en); ?></h3>
                    <?php endif; ?>
                </a>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>