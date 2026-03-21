<?php
/**
 * Custom Shop / Category Archive Page
 * Matches SHOP.CO Figma - Sidebar filters + 3-col product grid
 *
 * @package ShopCo
 */

defined( 'ABSPATH' ) || exit;

get_header();

$current_cat = get_queried_object();
$is_category = is_product_category();
$page_title  = $is_category ? $current_cat->name : 'Shop';
?>

<main class="shopco-main">
    <div class="container">

        <!-- Breadcrumb -->
        <nav class="shopco-breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
            <?php if ( $is_category && $current_cat->parent ) :
                $parent = get_term( $current_cat->parent, 'product_cat' );
                ?>
                <a href="<?php echo esc_url( get_term_link( $parent ) ); ?>"><?php echo esc_html( $parent->name ); ?></a>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
            <?php endif; ?>
            <span><?php echo esc_html( $page_title ); ?></span>
        </nav>

        <div class="shop-layout">

            <!-- ===== SIDEBAR FILTERS ===== -->
            <aside class="shop-filters" id="shopFilters">
                <div class="shop-filters__header">
                    <h2 class="shop-filters__title">
                        Filters
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M4 21V14M4 10V3M12 21V12M12 8V3M20 21V16M20 12V3M1 14h6M9 8h6M17 16h6" stroke="black" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </h2>
                    <button class="shop-filters__close" id="filtersClose" aria-label="Close filters">
                        <svg width="20" height="20" viewBox="0 0 14 14" fill="none">
                            <path d="M1 1L13 13M1 13L13 1" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <form method="get" action="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="shop-filters__form">

                    <!-- Category Filter -->
                    <div class="filter-group filter-group--open">
                        <button type="button" class="filter-group__toggle">
                            <span>Categories</span>
                            <svg width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </button>
                        <div class="filter-group__content">
                            <?php
                            $product_categories = get_terms( array(
                                'taxonomy'   => 'product_cat',
                                'hide_empty' => true,
                                'parent'     => 0,
                            ) );
                            if ( $product_categories && ! is_wp_error( $product_categories ) ) :
                                foreach ( $product_categories as $cat ) :
                                    $active = ( $is_category && $current_cat->term_id === $cat->term_id ) ? ' filter-link--active' : '';
                                    ?>
                                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="filter-link<?php echo $active; ?>">
                                        <?php echo esc_html( $cat->name ); ?>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
                                    </a>
                                <?php endforeach;
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="filter-group filter-group--open">
                        <button type="button" class="filter-group__toggle">
                            <span>Price</span>
                            <svg width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </button>
                        <div class="filter-group__content">
                            <div class="price-range-slider" id="priceRangeSlider">
                                <div class="price-range-slider__track">
                                    <div class="price-range-slider__fill" id="priceRangeFill"></div>
                                </div>
                                <input type="range" name="min_price" min="0" max="500" value="<?php echo esc_attr( isset( $_GET['min_price'] ) ? $_GET['min_price'] : '50' ); ?>" class="price-range-slider__input price-range-slider__input--min" id="priceMin">
                                <input type="range" name="max_price" min="0" max="500" value="<?php echo esc_attr( isset( $_GET['max_price'] ) ? $_GET['max_price'] : '200' ); ?>" class="price-range-slider__input price-range-slider__input--max" id="priceMax">
                            </div>
                            <div class="price-range-slider__values">
                                <span>$<span id="priceMinVal">50</span></span>
                                <span>$<span id="priceMaxVal">200</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Colors Filter -->
                    <div class="filter-group filter-group--open">
                        <button type="button" class="filter-group__toggle">
                            <span>Colors</span>
                            <svg width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </button>
                        <div class="filter-group__content">
                            <div class="color-swatches">
                                <?php
                                $colors = array(
                                    'green' => '#00C12B', 'red' => '#F50606', 'yellow' => '#F5DD06',
                                    'orange' => '#F57906', 'cyan' => '#06CAF5', 'blue' => '#063AF5',
                                    'purple' => '#7D06F5', 'pink' => '#F506A4', 'white' => '#FFFFFF',
                                    'black' => '#000000',
                                );
                                $selected_color = isset( $_GET['filter_color'] ) ? $_GET['filter_color'] : '';
                                foreach ( $colors as $name => $hex ) :
                                    $is_active = ( $selected_color === $name ) ? ' color-swatch--active' : '';
                                    ?>
                                    <label class="color-swatch<?php echo $is_active; ?>" style="background-color: <?php echo esc_attr( $hex ); ?>;" title="<?php echo esc_attr( ucfirst( $name ) ); ?>">
                                        <input type="radio" name="filter_color" value="<?php echo esc_attr( $name ); ?>" <?php checked( $selected_color, $name ); ?>>
                                        <svg class="color-swatch__check" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M3 7l3 3 5-5" stroke="<?php echo ( $name === 'white' || $name === 'yellow' ) ? 'black' : 'white'; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Size Filter -->
                    <div class="filter-group filter-group--open">
                        <button type="button" class="filter-group__toggle">
                            <span>Size</span>
                            <svg width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </button>
                        <div class="filter-group__content">
                            <div class="size-options">
                                <?php
                                $sizes = array( 'XX-Small', 'X-Small', 'Small', 'Medium', 'Large', 'X-Large', 'XX-Large', '3X-Large', '4X-Large' );
                                $selected_size = isset( $_GET['filter_size'] ) ? $_GET['filter_size'] : '';
                                foreach ( $sizes as $size ) :
                                    $is_active = ( $selected_size === $size ) ? ' size-option--active' : '';
                                    ?>
                                    <label class="size-option<?php echo $is_active; ?>">
                                        <input type="radio" name="filter_size" value="<?php echo esc_attr( $size ); ?>" <?php checked( $selected_size, $size ); ?>>
                                        <span><?php echo esc_html( $size ); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Dress Style Filter -->
                    <div class="filter-group filter-group--open">
                        <button type="button" class="filter-group__toggle">
                            <span>Dress Style</span>
                            <svg width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </button>
                        <div class="filter-group__content">
                            <?php
                            $styles = array( 'Casual', 'Formal', 'Party', 'Gym' );
                            foreach ( $styles as $style ) :
                                $term = get_term_by( 'name', $style, 'product_cat' );
                                $link = $term ? get_term_link( $term ) : '#';
                                ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="filter-link">
                                    <?php echo esc_html( $style ); ?>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn--primary shop-filters__apply">Apply Filter</button>
                </form>
            </aside>

            <!-- ===== PRODUCT GRID ===== -->
            <div class="shop-content">
                <div class="shop-content__header">
                    <h1 class="shop-content__title"><?php echo esc_html( $page_title ); ?></h1>
                    <div class="shop-content__meta">
                        <span class="shop-content__count">
                            Showing 1-<?php echo min( wc_get_loop_prop( 'per_page' ), wc_get_loop_prop( 'total' ) ); ?> of <?php echo wc_get_loop_prop( 'total' ); ?> Products
                        </span>
                        <div class="shop-content__sort">
                            Sort by:
                            <?php woocommerce_catalog_ordering(); ?>
                        </div>
                    </div>
                </div>

                <!-- Mobile Filter Toggle -->
                <button class="shop-filters__mobile-toggle" id="filtersMobileToggle">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M4 21V14M4 10V3M12 21V12M12 8V3M20 21V16M20 12V3M1 14h6M9 8h6M17 16h6" stroke="black" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Filters
                </button>

                <?php if ( woocommerce_product_loop() ) : ?>
                    <?php woocommerce_product_loop_start(); ?>

                    <?php if ( wc_get_loop_prop( 'total' ) ) :
                        while ( have_posts() ) :
                            the_post();
                            do_action( 'woocommerce_shop_loop' );
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                    endif; ?>

                    <?php woocommerce_product_loop_end(); ?>

                    <?php
                    /**
                     * Pagination
                     */
                    woocommerce_pagination();
                    ?>
                <?php else : ?>
                    <?php do_action( 'woocommerce_no_products_found' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Filters overlay for mobile -->
<div class="shop-filters-overlay" id="filtersOverlay"></div>

<?php get_footer(); ?>
