<?php if (have_rows('repeater_horizontal_album_gap_0')) : ?>
    <div class="row g-0">
        <?php while (have_rows('repeater_horizontal_album_gap_0')) : the_row(); 
            $image = get_sub_field('image');
        ?>
        <div class="col-6 col-md-6 col-lg-3 album-gap-0">
                <?php if ($image) : ?>
                    <img src="<?= esc_url($image['url']); ?>" alt="" />
                <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>