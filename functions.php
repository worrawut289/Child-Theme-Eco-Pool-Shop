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
require_once get_stylesheet_directory() . '/inc/quote-form.php';


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


// เปลี่ยนชื่อแท็บ "รายละเอียดสินค้า" เป็น "Features"
add_filter('woocommerce_product_tabs', 'custom_rename_description_tab', 98);
function custom_rename_description_tab($tabs) {
    if (isset($tabs['description'])) {
        $tabs['description']['title'] = __('Features', 'text-domain'); 
    }
    return $tabs;
}

// เพิ่มแท็บใหม่
add_filter('woocommerce_product_tabs', 'custom_product_tabs');
function custom_product_tabs($tabs) {
    // Technical specification Tab
    if (get_field('technical_specification')) {
        $tabs['technical_specification_tab'] = array(
            'title'    => __('Technical specification', 'text-domain'),
            'priority' => 10,
            'callback' => 'custom_techinfo_tab_content'
        );
    }

    return $tabs;
}
    

// แสดงเนื้อหา Technical specification
function custom_techinfo_tab_content() {
    echo get_field('technical_specification');
}


/**
 * Shortcode: [feature_product_section]
 * แสดง section feature-product (application + PDF download)
 */
function feature_product_section_shortcode() {
    ob_start();
    $template = locate_template('template-parts/feature-product.php');
    if ($template) {
        include $template;
    }
    return ob_get_clean();
}
add_shortcode('feature_product_section', 'feature_product_section_shortcode');


/**
 * Show ACF Fields in WooCommerce Order Details
 * This function displays custom ACF fields in the WooCommerce order details page.
 */
add_action( 'woocommerce_order_details_after_order_table', 'oggy_show_tracking_acf_fields', 10 );


function oggy_show_tracking_acf_fields( $order ) {
    // ใช้ get_field() จาก ACF
    $tracking = get_field('tracking_number', $order->get_id());
    $company_value = get_field('shipping_company', $order->get_id());
    $company_label = '';

    $choices = [
        'thailand_post' => 'ไปรษณีย์ไทย EMS',
        'kerry' => 'Kerry Express',
        'jnt' => 'J&T Express',
        'flash' => 'Flash Express',
        'shopee' => 'SPX Express',
        'lex' => 'LEX Express',
        'ninja' => 'Ninja Van',
        'dhl' => 'DHL',
        'ups' => 'UPS',
        'best' => 'Best Express',
        'scg' => 'SCG Express',
        'fedex' => 'FedEx',
        'nim' => 'Nim Express',
        'lalamove' => 'Lalamove',
    ];

    if ( isset($choices[$company_value]) ) {
        $company_label = $choices[$company_value];
    }
    

    if ( $company_label || $tracking ) {
        echo '<section class="woocommerce-order-tracking">';
        echo '<h2>ข้อมูลการจัดส่ง</h2>';
        echo '<ul class="woocommerce-shipping-tracking">';

        if ( $company_label ) {
            echo '<li><strong>บริษัทขนส่ง:</strong> <span>' . esc_html($company_label) . '</span></li>';
        }

        if ( $tracking ) {
            echo '<li><strong>เลขพัสดุ:</strong> <span>' . esc_html($tracking) . '</span></li>';
        }

        echo '</ul>';
        echo '</section>';
    }
}


/**
 * WooCommerce: Featured Products on Top
 * This function modifies the WooCommerce product query to display featured products at the top.
 * It is applied on shop and product category pages.
 */
add_action( 'woocommerce_product_query', function( $q ) {
    if ( is_product_category() || is_product_taxonomy() ) {

        // ดึง Featured IDs
        $featured_ids = wc_get_featured_product_ids();

        if ( ! empty( $featured_ids ) ) {
            // รวมสินค้าปกติทั้งหมดที่ query อยู่
            $all_ids = get_posts( array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'fields'         => 'ids',
                'post_status'    => 'publish',
                'tax_query'      => $q->get( 'tax_query' ), // ใช้ filter หมวดหมู่เดียวกับ query เดิม
                'meta_query'     => $q->get( 'meta_query' ),
            ) );

            // จัด Featured ไว้ด้านบน
            $ordered_ids = array_unique( array_merge( $featured_ids, $all_ids ) );

            $q->set( 'post__in', $ordered_ids );
            $q->set( 'orderby', 'post__in' );
        }
    }
});



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

add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'best-seller-section',
        'title'           => __('ACF Best Seller', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/best-seller-section.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['best', 'seller', 'product'],
    ]);
});

add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'group_pool_service_overview',
        'title'           => __('ACF Pool Service Overview', 'your-textdomain'),
        'render_template' => get_stylesheet_directory() . '/template-parts/blocks/pool-service-overview.php',
        'category'        => 'formatting',
        'icon'            => 'images-alt2',
        'keywords'        => ['pool', 'service', 'overview'],
    ]);
});