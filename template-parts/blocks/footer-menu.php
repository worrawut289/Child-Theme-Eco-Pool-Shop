<?php if (have_rows('repeater_footer_menu')) : ?>
<div class="container">
    <div class="row g-4">
        <ul class="ul-footer-menu">
            <?php while (have_rows('repeater_footer_menu')) : the_row(); 
            $name = get_sub_field('name');
            $link = get_sub_field('link');
        ?>
            <?php if ($name && $link) : ?>
            <li>
                <a href="<?= esc_url(is_array($link) && isset($link['link']) ? $link['link'] : $link); ?>">
                    <?= esc_html($name); ?>
                </a>
            </li>
            <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
<?php endif; ?>