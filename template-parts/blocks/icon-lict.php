<?php if (have_rows('reprater_icon_list')) : ?>
<div class="container">
    <div class="row g-4">
        <?php while (have_rows('reprater_icon_list')) : the_row(); 
            $image = get_sub_field('image');
            $title = get_sub_field('title');
            $detail = get_sub_field('detail');
        ?>
        <div class="col-6 col-md-6 col-lg-3">
            <div class="feature-item">
                <?php if ($image) : ?>
                <!-- เพิ่มคลาส "feature-icon-bg" ครอบ img -->
                <span class="feature-icon-bg">
                    <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($title); ?>" class="feature-icon" />
                </span>
                <?php endif; ?>
                <div class="feature-text">
                    <h1 class="feature-title"><?= esc_html($title); ?></h1>
                    <p class="feature-sub"><?= esc_html($detail); ?></p>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>