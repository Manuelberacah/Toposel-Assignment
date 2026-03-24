<?php
/**
 * ShopCo Theme Functions
 *
 * @package ShopCo
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SHOPCO_VERSION', '1.0.0' );
define( 'SHOPCO_DIR', get_template_directory() );
define( 'SHOPCO_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function shopco_setup() {
    // Title tag support
    add_theme_support( 'title-tag' );

    // Post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes
    add_image_size( 'shopco-product-card', 295, 298, true );
    add_image_size( 'shopco-hero', 600, 600, false );
    add_image_size( 'shopco-category', 400, 300, true );

    // Navigation menus
    register_nav_menus( array(
        'primary'   => __( 'Primary Menu', 'shopco' ),
        'footer-company' => __( 'Footer Company', 'shopco' ),
        'footer-help'    => __( 'Footer Help', 'shopco' ),
        'footer-faq'     => __( 'Footer FAQ', 'shopco' ),
        'footer-resources' => __( 'Footer Resources', 'shopco' ),
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 40,
        'width'       => 160,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'shopco_setup' );

/**
 * Enqueue Styles and Scripts
 */
function shopco_scripts() {
    // Google Fonts - Satoshi & Integral CF alternatives
    wp_enqueue_style(
        'shopco-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700;800;900&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'shopco-main',
        SHOPCO_URI . '/assets/css/main.css',
        array(),
        SHOPCO_VERSION
    );

    // Theme stylesheet (WordPress requirement)
    wp_enqueue_style(
        'shopco-style',
        get_stylesheet_uri(),
        array( 'shopco-main' ),
        SHOPCO_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'shopco-main',
        SHOPCO_URI . '/assets/js/main.js',
        array(),
        SHOPCO_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script( 'shopco-main', 'shopcoAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'shopco_nonce' ),
    ) );

    // WooCommerce cart fragment support
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script( 'wc-cart-fragments' );
    }
}
add_action( 'wp_enqueue_scripts', 'shopco_scripts' );

/**
 * Register Widget Areas
 */
function shopco_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Shop Sidebar', 'shopco' ),
        'id'            => 'shop-sidebar',
        'description'   => __( 'Sidebar for shop pages', 'shopco' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'shopco_widgets_init' );

/**
 * Custom Walker for Primary Navigation
 */
class ShopCo_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = array();
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
        $atts['class'] = 'nav-link';

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        if ( $has_children && $depth === 0 ) {
            $item_output .= ' <svg width="10" height="6" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>';
        }
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= $item_output;
    }
}

/**
 * WooCommerce customizations
 */
if ( class_exists( 'WooCommerce' ) ) {
    // Remove default WooCommerce wrappers
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

    // Add custom wrappers
    function shopco_wc_wrapper_start() {
        echo '<main class="shopco-main"><div class="container">';
    }
    add_action( 'woocommerce_before_main_content', 'shopco_wc_wrapper_start', 10 );

    function shopco_wc_wrapper_end() {
        echo '</div></main>';
    }
    add_action( 'woocommerce_after_main_content', 'shopco_wc_wrapper_end', 10 );

    // Remove default sidebar
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

    // Customize products per page (9 = 3x3 grid matching Figma)
    function shopco_products_per_page( $cols ) {
        return 9;
    }
    add_filter( 'loop_shop_per_page', 'shopco_products_per_page' );

    // Customize product columns (3 for category page with sidebar)
    function shopco_loop_columns() {
        return 3;
    }
    add_filter( 'loop_shop_columns', 'shopco_loop_columns' );

    // Remove default WooCommerce styles that conflict
    add_filter( 'woocommerce_enqueue_styles', function( $styles ) {
        unset( $styles['woocommerce-layout'] );
        return $styles;
    } );

    // Remove related products default hook (we handle it in our template)
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

    // Remove default product tabs (we use custom tabs)
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

    // Remove upsell display from default location
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

    // Remove default WC My Account navigation (we render our own in my-account.php)
    remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation', 10 );

    // Inject My Account inline CSS to guarantee it loads
    function shopco_myaccount_inline_css() {
        if ( ! is_account_page() ) return;
        ?>
        <style id="shopco-myaccount-css">
            .myaccount-layout{display:grid;grid-template-columns:280px 1fr;gap:32px;align-items:start;padding:20px 0 80px}
            .myaccount-sidebar{border:1px solid #E6E6E6;border-radius:20px;overflow:hidden}
            .myaccount-sidebar__user{display:flex;align-items:center;gap:14px;padding:24px 20px;border-bottom:1px solid #E6E6E6;background:#F0F0F0}
            .myaccount-sidebar__avatar{width:48px;height:48px;border-radius:50%;overflow:hidden;flex-shrink:0;background:#ccc}
            .myaccount-sidebar__avatar img{width:100%;height:100%;object-fit:cover;border-radius:50%}
            .myaccount-sidebar__name{font-size:16px;font-weight:700;line-height:1.3;margin:0}
            .myaccount-sidebar__email{font-size:13px;color:#999;margin-top:2px;word-break:break-all}
            .myaccount-nav__list{list-style:none;margin:0;padding:8px 0}
            .myaccount-nav__item{margin:0}
            .myaccount-nav__link{display:flex;align-items:center;gap:12px;padding:14px 20px;font-size:15px;font-weight:500;color:#666;transition:all .2s;border-left:3px solid transparent;text-decoration:none}
            .myaccount-nav__link:hover{background:#F0F0F0;color:#000;opacity:1}
            .myaccount-nav__item--active .myaccount-nav__link{background:#F0F0F0;color:#000;font-weight:600;border-left-color:#000}
            .myaccount-nav__link svg{flex-shrink:0;opacity:.7}
            .myaccount-nav__item--active .myaccount-nav__link svg{opacity:1}
            .myaccount-nav__item--logout{border-top:1px solid #E6E6E6;margin-top:4px;padding-top:4px}
            .myaccount-nav__item--logout .myaccount-nav__link{color:#FF3333}
            .myaccount-nav__item--logout .myaccount-nav__link:hover{background:#fff5f5}
            .myaccount-content{min-height:400px}
            .myaccount-content > p{font-size:16px;line-height:1.7;color:#666;margin-bottom:16px}
            .myaccount-content > p strong{color:#000}
            .myaccount-content > p a{color:#000;font-weight:600;text-decoration:underline}
            .myaccount-content .woocommerce-info,.myaccount-content .woocommerce-message{padding:16px 20px;border-radius:12px;background:#F0F0F0;border-left:4px solid #000;margin-bottom:20px}
            .myaccount-content .woocommerce-Button,.myaccount-content button[type="submit"],.myaccount-content .button{background:#000!important;color:#fff!important;border:none!important;border-radius:62px!important;padding:14px 32px!important;font-size:16px!important;font-weight:500!important;cursor:pointer}
            .myaccount-content input[type="text"],.myaccount-content input[type="email"],.myaccount-content input[type="password"],.myaccount-content input[type="tel"],.myaccount-content select,.myaccount-content input.input-text{width:100%;padding:12px 16px;border:1px solid #E6E6E6;border-radius:8px;font-size:15px;font-family:inherit}
            .myaccount-content input:focus,.myaccount-content select:focus{outline:none;border-color:#000}
            .myaccount-content .woocommerce-orders-table{width:100%;border-collapse:collapse;border:1px solid #E6E6E6;border-radius:12px;overflow:hidden}
            .myaccount-content .woocommerce-orders-table thead th{background:#F0F0F0;padding:14px 16px;text-align:left;font-weight:600;font-size:14px;border-bottom:1px solid #E6E6E6}
            .myaccount-content .woocommerce-orders-table tbody td{padding:14px 16px;border-bottom:1px solid #E6E6E6;font-size:15px}
            .myaccount-content .woocommerce-Addresses{display:grid;grid-template-columns:1fr 1fr;gap:20px}
            .myaccount-content .woocommerce-Address{border:1px solid #E6E6E6;border-radius:12px;padding:20px}
            .myaccount-content .woocommerce-Address header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #E6E6E6}
            .woocommerce-MyAccount-navigation{display:none!important}
            .woocommerce-MyAccount-content{width:100%!important;float:none!important}
            @media(max-width:768px){.myaccount-layout{grid-template-columns:1fr;gap:20px}.myaccount-content .woocommerce-Addresses{grid-template-columns:1fr}}
        </style>
        <?php
    }
    add_action( 'wp_head', 'shopco_myaccount_inline_css' );

    // Inject Single Product inline CSS to guarantee layout
    function shopco_single_product_inline_css() {
        if ( ! is_product() ) return;
        ?>
        <style id="shopco-single-product-css">
            /* Reset WC default product grid */
            .woocommerce div.product,
            .shopco-single-product{display:block!important;grid-template-columns:none!important;float:none!important;width:100%!important}
            .shopco-single-product{max-width:100%}
            /* Row 1: Gallery + Details */
            .sp-top{display:grid!important;grid-template-columns:1fr 1fr!important;gap:40px;padding-bottom:40px;align-items:start}
            /* Gallery */
            .sp-gallery{display:flex;gap:14px}
            .sp-gallery__thumbs{display:flex;flex-direction:column;gap:10px;width:80px;flex-shrink:0}
            .sp-gallery__thumb{width:80px;height:80px;border-radius:12px;overflow:hidden;border:2px solid transparent;cursor:pointer;padding:0;background:#F0F0F0}
            .sp-gallery__thumb--active{border-color:#000}
            .sp-gallery__thumb img{width:100%;height:100%;object-fit:cover}
            .sp-gallery__main{flex:1;border-radius:20px;overflow:hidden;background:#F0F0F0;aspect-ratio:1}
            .sp-gallery__main img{width:100%;height:100%;object-fit:cover}
            /* Details */
            .sp-details__title{font-family:'Montserrat',sans-serif;font-size:40px;font-weight:900;text-transform:uppercase;line-height:1.1;margin-bottom:12px}
            .sp-details__rating{margin-bottom:16px}
            .sp-details__price{display:flex;align-items:center;gap:12px;margin-bottom:16px;flex-wrap:wrap}
            .sp-price{font-size:32px;font-weight:700;color:#000}
            .sp-price--old{color:#999;text-decoration:line-through}
            .sp-details__desc{font-size:16px;color:#666;line-height:1.6;margin-bottom:16px}
            .sp-details__desc p{margin:0}
            .sp-details__hr{border:none;border-top:1px solid #E6E6E6;margin:20px 0}
            .sp-details__option{margin-bottom:20px}
            .sp-details__label{display:block;font-size:14px;color:#666;margin-bottom:10px}
            /* Colors */
            .sp-colors{display:flex;gap:10px}
            .sp-color{width:36px;height:36px;border-radius:50%;cursor:pointer;position:relative;display:flex;align-items:center;justify-content:center;border:none}
            .sp-color input{position:absolute;opacity:0;width:0;height:0}
            .sp-color svg{display:none}
            .sp-color--active svg{display:block}
            /* Sizes */
            .sp-sizes{display:flex;gap:8px;flex-wrap:wrap}
            .sp-size{cursor:pointer;position:relative}
            .sp-size input{position:absolute;opacity:0;width:0;height:0}
            .sp-size span{display:inline-block;padding:10px 20px;border-radius:62px;font-size:14px;background:#F0F0F0;color:#666;transition:all .2s}
            .sp-size--active span{background:#000;color:#fff}
            .sp-size:hover span{background:#E6E6E6}
            .sp-size--active:hover span{background:#333}
            /* Add to Cart area */
            .sp-addtocart .cart{display:flex;gap:12px;align-items:center}
            .sp-addtocart .quantity{display:flex;align-items:center;background:#F0F0F0;border-radius:62px;overflow:hidden}
            .sp-addtocart .quantity input{width:50px;text-align:center;font-size:16px;font-weight:500;background:none;border:none;padding:14px 0;font-family:inherit}
            .sp-addtocart .quantity input::-webkit-inner-spin-button{-webkit-appearance:none}
            .sp-addtocart .single_add_to_cart_button{flex:1;background:#000!important;color:#fff!important;border-radius:62px!important;padding:14px 32px!important;font-weight:500!important;font-size:16px!important;border:none;cursor:pointer}
            /* Tabs - FULL WIDTH below */
            .sp-tabs{margin-top:40px;border-top:1px solid #E6E6E6;width:100%;clear:both}
            .sp-tabs__nav{display:flex;border-bottom:1px solid #E6E6E6}
            .sp-tabs__btn{flex:1;padding:16px;text-align:center;font-size:16px;font-weight:500;color:#999;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;font-family:inherit}
            .sp-tabs__btn:hover{color:#000}
            .sp-tabs__btn--active{color:#000;font-weight:600;border-bottom-color:#000}
            .sp-tabs__panel{padding:24px 0}
            /* Reviews */
            .sp-reviews-header{display:flex;align-items:center;justify-content:space-between;padding:0 0 20px;flex-wrap:wrap;gap:12px}
            .sp-reviews-title{font-size:24px;font-weight:700}
            .sp-reviews-actions{display:flex;align-items:center;gap:10px}
            .sp-reviews-sort{padding:8px 16px;border-radius:8px;border:1px solid #E6E6E6;font-family:inherit;font-size:14px;background:none;cursor:pointer}
            .sp-reviews-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px}
            .sp-review-card{border:1px solid #E6E6E6;border-radius:20px;padding:24px 28px}
            /* Related */
            .sp-related{padding-top:60px}
            /* WC defaults to hide */
            .shopco-single-product .woocommerce-product-gallery,
            .shopco-single-product .summary,
            .shopco-single-product .woocommerce-tabs{display:none!important}
            /* Responsive */
            @media(max-width:768px){
                .sp-top{grid-template-columns:1fr!important;gap:24px}
                .sp-gallery{flex-direction:column-reverse}
                .sp-gallery__thumbs{flex-direction:row;width:100%}
                .sp-gallery__thumb{width:60px;height:60px}
                .sp-details__title{font-size:28px}
                .sp-price{font-size:24px}
                .sp-reviews-grid{grid-template-columns:1fr}
            }
        </style>
        <?php
    }
    add_action( 'wp_head', 'shopco_single_product_inline_css' );

    // Cart count AJAX fragment
    function shopco_cart_count_fragment( $fragments ) {
        ob_start();
        ?>
        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php
        $fragments['.cart-count'] = ob_get_clean();
        return $fragments;
    }
    add_filter( 'woocommerce_add_to_cart_fragments', 'shopco_cart_count_fragment' );
}

/**
 * Helper: Display star rating HTML
 */
function shopco_star_rating( $rating = 5, $max = 5 ) {
    $output = '<div class="star-rating">';
    for ( $i = 1; $i <= $max; $i++ ) {
        if ( $i <= floor( $rating ) ) {
            $output .= '<svg width="18" height="18" viewBox="0 0 24 24" fill="#FFC633"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        } elseif ( $i - $rating < 1 && $i - $rating > 0 ) {
            $output .= '<svg width="18" height="18" viewBox="0 0 24 24"><defs><linearGradient id="half-' . $i . '"><stop offset="50%" stop-color="#FFC633"/><stop offset="50%" stop-color="#D9D9D9"/></linearGradient></defs><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="url(#half-' . $i . ')"/></svg>';
        } else {
            $output .= '<svg width="18" height="18" viewBox="0 0 24 24" fill="#D9D9D9"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        }
    }
    $output .= '<span class="rating-value">' . $rating . '/5</span>';
    $output .= '</div>';
    return $output;
}

/**
 * Custom excerpt length
 */
function shopco_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'shopco_excerpt_length' );

/**
 * Add body classes
 */
function shopco_body_classes( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'shopco-home';
    }
    if ( class_exists( 'WooCommerce' ) ) {
        if ( is_shop() || is_product_category() || is_product_tag() ) {
            $classes[] = 'shopco-shop';
        }
        if ( is_product() ) {
            $classes[] = 'shopco-product';
        }
    }
    return $classes;
}
add_filter( 'body_class', 'shopco_body_classes' );

/**
 * Customizer settings for theme options
 */
function shopco_customizer( $wp_customize ) {
    // Top Banner Section
    $wp_customize->add_section( 'shopco_banner', array(
        'title'    => __( 'Top Banner', 'shopco' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'shopco_banner_text', array(
        'default'           => 'Sign up and get 20% off to your first order.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'shopco_banner_text', array(
        'label'   => __( 'Banner Text', 'shopco' ),
        'section' => 'shopco_banner',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'shopco_banner_link_text', array(
        'default'           => 'Sign Up Now',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'shopco_banner_link_text', array(
        'label'   => __( 'Banner Link Text', 'shopco' ),
        'section' => 'shopco_banner',
        'type'    => 'text',
    ) );

    // Hero Section
    $wp_customize->add_section( 'shopco_hero', array(
        'title'    => __( 'Hero Section', 'shopco' ),
        'priority' => 31,
    ) );

    $wp_customize->add_setting( 'shopco_hero_title', array(
        'default'           => 'FIND CLOTHES THAT MATCHES YOUR STYLE',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'shopco_hero_title', array(
        'label'   => __( 'Hero Title', 'shopco' ),
        'section' => 'shopco_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'shopco_hero_subtitle', array(
        'default'           => 'Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'shopco_hero_subtitle', array(
        'label'   => __( 'Hero Subtitle', 'shopco' ),
        'section' => 'shopco_hero',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'shopco_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shopco_hero_image', array(
        'label'   => __( 'Hero Image', 'shopco' ),
        'section' => 'shopco_hero',
    ) ) );

    // Newsletter Section
    $wp_customize->add_section( 'shopco_newsletter', array(
        'title'    => __( 'Newsletter', 'shopco' ),
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'shopco_newsletter_title', array(
        'default'           => 'STAY UP TO DATE ABOUT OUR LATEST OFFERS',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'shopco_newsletter_title', array(
        'label'   => __( 'Newsletter Title', 'shopco' ),
        'section' => 'shopco_newsletter',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'shopco_customizer' );

/**
 * ============================================================
 * ACF Field Groups - Homepage Dynamic Content
 * ============================================================
 * Registers all ACF fields programmatically so they ship with
 * the theme. Requires the ACF (free or Pro) plugin to be active.
 */
function shopco_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // ── Announcement Bar ──
    acf_add_local_field_group( array(
        'key'      => 'group_announcement_bar',
        'title'    => 'Announcement Bar',
        'fields'   => array(
            array(
                'key'           => 'field_announcement_text',
                'label'         => 'Announcement Text',
                'name'          => 'announcement_text',
                'type'          => 'text',
                'default_value' => 'Sign up and get 20% off to your first order.',
                'instructions'  => 'The promotional text shown in the top black banner.',
            ),
            array(
                'key'           => 'field_announcement_link_text',
                'label'         => 'Link Text',
                'name'          => 'announcement_link_text',
                'type'          => 'text',
                'default_value' => 'Sign Up Now',
                'instructions'  => 'The clickable link text next to the announcement.',
            ),
            array(
                'key'           => 'field_announcement_link_url',
                'label'         => 'Link URL',
                'name'          => 'announcement_link_url',
                'type'          => 'url',
                'default_value' => '',
                'instructions'  => 'Where the link text points to. Leave empty for default registration page.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
    ) );

    // ── Hero Section ──
    acf_add_local_field_group( array(
        'key'      => 'group_hero_section',
        'title'    => 'Hero Section',
        'fields'   => array(
            array(
                'key'           => 'field_hero_heading',
                'label'         => 'Heading',
                'name'          => 'hero_heading',
                'type'          => 'text',
                'default_value' => 'FIND CLOTHES THAT MATCHES YOUR STYLE',
                'instructions'  => 'Main hero title.',
            ),
            array(
                'key'           => 'field_hero_subheading',
                'label'         => 'Subheading',
                'name'          => 'hero_subheading',
                'type'          => 'textarea',
                'default_value' => 'Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.',
                'instructions'  => 'Text below the hero title.',
                'rows'          => 3,
            ),
            array(
                'key'           => 'field_hero_image',
                'label'         => 'Hero Image',
                'name'          => 'hero_image',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'instructions'  => 'Upload the main hero banner image.',
            ),
            array(
                'key'           => 'field_hero_button_text',
                'label'         => 'Button Text',
                'name'          => 'hero_button_text',
                'type'          => 'text',
                'default_value' => 'Shop Now',
            ),
            array(
                'key'           => 'field_hero_button_link',
                'label'         => 'Button Link',
                'name'          => 'hero_button_link',
                'type'          => 'url',
                'default_value' => '',
                'instructions'  => 'Leave empty to link to the Shop page.',
            ),
            array(
                'key'   => 'field_hero_stats',
                'label' => 'Statistics',
                'name'  => 'hero_stats',
                'type'  => 'repeater',
                'instructions' => 'The counters shown below the hero (e.g. 200+ International Brands).',
                'min'        => 0,
                'max'        => 4,
                'layout'     => 'table',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_stat_number',
                        'label' => 'Number',
                        'name'  => 'stat_number',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'field_stat_label',
                        'label' => 'Label',
                        'name'  => 'stat_label',
                        'type'  => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'menu_order' => 1,
        'position'   => 'normal',
        'style'      => 'default',
    ) );

    // ── Brand Logos Bar ──
    acf_add_local_field_group( array(
        'key'      => 'group_brand_logos',
        'title'    => 'Brand Logos Bar',
        'fields'   => array(
            array(
                'key'          => 'field_brand_logos',
                'label'        => 'Brand Logos',
                'name'         => 'brand_logos',
                'type'         => 'repeater',
                'instructions' => 'Upload brand logo images. Use white/transparent PNG logos for best results on the black background.',
                'min'          => 0,
                'max'          => 10,
                'layout'       => 'block',
                'sub_fields'   => array(
                    array(
                        'key'           => 'field_brand_logo_image',
                        'label'         => 'Logo Image',
                        'name'          => 'brand_logo_image',
                        'type'          => 'image',
                        'return_format' => 'array',
                        'preview_size'  => 'thumbnail',
                        'instructions'  => 'Upload a brand logo (recommended: white PNG on transparent background).',
                    ),
                    array(
                        'key'   => 'field_brand_logo_name',
                        'label' => 'Brand Name',
                        'name'  => 'brand_logo_name',
                        'type'  => 'text',
                        'instructions' => 'Used as alt text for accessibility.',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'menu_order' => 2,
        'position'   => 'normal',
        'style'      => 'default',
    ) );

    // ── New Arrivals Section ──
    acf_add_local_field_group( array(
        'key'      => 'group_new_arrivals',
        'title'    => 'New Arrivals Section',
        'fields'   => array(
            array(
                'key'           => 'field_new_arrivals_title',
                'label'         => 'Section Title',
                'name'          => 'new_arrivals_title',
                'type'          => 'text',
                'default_value' => 'NEW ARRIVALS',
            ),
            array(
                'key'          => 'field_new_arrivals_category',
                'label'        => 'Product Category / Collection',
                'name'         => 'new_arrivals_category',
                'type'         => 'taxonomy',
                'taxonomy'     => 'product_cat',
                'field_type'   => 'select',
                'allow_null'   => 1,
                'return_format'=> 'id',
                'instructions' => 'Choose which product category to display in the New Arrivals section. Leave empty to show the latest products.',
            ),
            array(
                'key'           => 'field_new_arrivals_count',
                'label'         => 'Number of Products',
                'name'          => 'new_arrivals_count',
                'type'          => 'number',
                'default_value' => 4,
                'min'           => 1,
                'max'           => 8,
                'instructions'  => 'How many product cards to display.',
            ),
            array(
                'key'           => 'field_new_arrivals_view_all_link',
                'label'         => 'View All Link',
                'name'          => 'new_arrivals_view_all_link',
                'type'          => 'url',
                'default_value' => '',
                'instructions'  => 'Leave empty to link to the Shop page.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'menu_order' => 3,
        'position'   => 'normal',
        'style'      => 'default',
    ) );
}
add_action( 'acf/init', 'shopco_register_acf_fields' );

/**
 * ACF JSON save/load paths (so field changes are version-controlled)
 */
function shopco_acf_json_save_point( $path ) {
    return SHOPCO_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'shopco_acf_json_save_point' );

function shopco_acf_json_load_point( $paths ) {
    $paths[] = SHOPCO_DIR . '/acf-json';
    return $paths;
}
add_filter( 'acf/settings/load_json', 'shopco_acf_json_load_point' );

/**
 * Admin notice if ACF is not installed
 */
function shopco_acf_admin_notice() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>ShopCo Theme:</strong> Please install and activate the <a href="' . admin_url( 'plugin-install.php?s=advanced+custom+fields&tab=search&type=term' ) . '">Advanced Custom Fields</a> plugin to enable full homepage content management.</p>';
        echo '</div>';
    }
}
add_action( 'admin_notices', 'shopco_acf_admin_notice' );
