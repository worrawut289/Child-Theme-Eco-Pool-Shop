<?php
/**
 * Pool Equipment Asia Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pool Equipment Asia
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_POOL_EQUIPMENT_ASIA_VERSION', '1.0.0' );


/**
 * Enqueue Custom Scripts
 * This function enqueues custom JavaScript files for the theme.
 * It is used to add interactivity and functionality to the theme.
 */
require_once get_stylesheet_directory() . '/inc/best-sellers.php';
require_once get_stylesheet_directory() . '/inc/category-posts.php';
require_once get_stylesheet_directory() . '/inc/latest-products.php';


// กำหนดจำนวนตัวอักษรที่คุณต้องการ
function custom_excerpt_length($length) {
    return 120; 
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);


/**
 * Enqueue styles
 */
function child_enqueue_styles() {
    // โหลด style.css ปกติ (ของธีมลูก)
    wp_enqueue_style(
        'pool-equipment-asia-theme-css',
        get_stylesheet_directory_uri() . '/style.css',
        array('astra-theme-css'),
        CHILD_THEME_POOL_EQUIPMENT_ASIA_VERSION,
        'all'
    );

    // ✅ โหลด assets/style.css เพิ่มเติม
    wp_enqueue_style(
        'pool-equipment-asia-assets-css',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        array(), // หรือใส่ array('pool-equipment-asia-theme-css') ถ้าอยากให้โหลดหลังจาก style หลัก
        CHILD_THEME_POOL_EQUIPMENT_ASIA_VERSION,
        'all'
    );
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


/**
 * Enqueue scripts
 */
add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});


/**
 * ACF JSON Save Path
 * This filter changes the path where ACF saves JSON files.
 * It is used to store ACF field groups in a specific directory within the child theme.
 */
add_filter('acf/settings/load_json', function ($paths) {
    // ลบ path เดิม
    unset($paths[0]);

    // เพิ่ม path ของธีมลูก
    $paths[] = get_stylesheet_directory() . '/acf-json';

    return $paths;
});




/**
 * Enqueue Bootstrap Grid Only
 * This function enqueues the Bootstrap grid CSS file.
 * It is used to provide a responsive grid system without the full Bootstrap framework.
 */
function enqueue_bootstrap_grid_only() {
  wp_enqueue_style(
    'bootstrap-grid',
    get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css',
    [],
    '5.3.0'
  );
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_grid_only');



/**
 * Enqueue FontAwesome Local
 * This function enqueues the local FontAwesome CSS file.
 * It is used to include FontAwesome icons in the theme without relying on a CDN.
 */
function enqueue_fontawesome_local() {
  wp_enqueue_style(
    'fontawesome-local',
    get_stylesheet_directory_uri() . '/assets/fontawesome/css/all.min.css',
    [],
    '6.5.0' 
);
}
add_action('wp_enqueue_scripts', 'enqueue_fontawesome_local');




/**
 * Swiper
 */
function enqueue_swiper_assets() {
    wp_enqueue_style(
        'swiper-css',
        get_stylesheet_directory_uri() . '/assets/swiper/swiper-bundle.min.css',
        [],
        '11.0.5'
    );

    wp_enqueue_script(
        'swiper-js',
        get_stylesheet_directory_uri() . '/assets/swiper/swiper-bundle.min.js',
        [],
        '11.0.5',
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');



/**
 * Register ACF Block Type
 */
add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'slide-block',
        'title'           => __('ACF Slide Block', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/slide-block.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['slide', 'carousel', 'swiper'],
    ]);
});

add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'featured-product-categories',
        'title'           => __('ACF Featured Product Categories', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/featured-product-categories.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['product', 'categories'],
    ]);
});

add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'icon-list',
        'title'           => __('ACF Icon List', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/icon-lict.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['product', 'categories', 'icon', 'list'],
    ]);
});

add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'heading-with-link',
        'title'           => __('ACF Heading With Link', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/heading-with-link.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['heading', 'link', 'title'],
    ]);
});

add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'logo-brand',
        'title'           => __('ACF Logo Brand', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/logo-brand.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['logo', 'brand', 'partner'],
    ]);
});


add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'footer-menu',
        'title'           => __('ACF Footer Menu', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/footer-menu.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['menu', 'footer', 'navigation'],
    ]);
});


add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'horizontal-album-gap-0',
        'title'           => __('ACF Horizontal Album Gap 0', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/horizontal-album-gap-0.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['album'],
    ]);
});


add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'line-contact',
        'title'           => __('ACF Line Contact', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/line-contact.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['contact', 'line'],
    ]);
});