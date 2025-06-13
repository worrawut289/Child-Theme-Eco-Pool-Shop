<?php
// /template-parts/shortcodes/category-posts-shortcode.php

function shortcode_category_posts($atts) {
    ob_start();

    $atts = shortcode_atts(array(
        'cat'      => '',
        'per_page' => 3,
        'paged'    => (get_query_var('paged')) ? get_query_var('paged') : 1,
    ), $atts);

    $cat_id = is_numeric($atts['cat']) ? intval($atts['cat']) : '';
    if (!$cat_id && $atts['cat']) {
        $term = get_term_by('slug', $atts['cat'], 'category');
        if ($term) $cat_id = $term->term_id;
    }

    $query_post = new WP_Query(array(
        'cat'            => $cat_id,
        'orderby'        => 'date',
        'post_type'      => 'post',
        'posts_per_page' => intval($atts['per_page']),
        'paged'          => $atts['paged'],
    ));
    ?>
<div class="container">
    <div class="row">
        <?php if ($query_post->have_posts()) : ?>
        <?php while ($query_post->have_posts()) : $query_post->the_post(); ?>
        <div class="col-12 col-md-4 col-lg-4 mt-3">
            <a class="link-category-posts " href="<?php the_permalink(); ?>">
                <div class="box-category-posts">
                    <div class="img-post">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                    </div>
                    <div class="box-title-post ">
                        <!-- <span class="date-post">
                            <i class="fa-regular fa-calendar"></i>
                            <?php echo get_the_date(); ?>
                        </span> -->
                        <h1 class="title-post "><?php echo the_title(); ?></h1>
                    </div>
                    <div class="detail-post">
                        <?php echo the_excerpt(); ?>
                    </div>
                    <div class="box-category-footer">
                        <a href="<?php the_permalink(); ?>">Read More</a>
                    </div>
                </div>
            </a>
        </div>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>
        <?php else : ?>
        <div class="sorry-no-post d-flex justify-content-center">
            <p><?php _e('** ไม่มีบทความ **'); ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php

    return ob_get_clean();
}
add_shortcode('category_posts', 'shortcode_category_posts');