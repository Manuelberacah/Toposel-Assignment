<?php
/**
 * Template Name: Home Page
 * The front page template
 *
 * @package ShopCo
 */

get_header();
?>

<!-- ======= HERO SECTION ======= -->
<?php
    // ACF fields with Customizer fallbacks
    $hero_title    = get_field( 'hero_heading' ) ?: get_theme_mod( 'shopco_hero_title', 'FIND CLOTHES THAT MATCHES YOUR STYLE' );
    $hero_subtitle = get_field( 'hero_subheading' ) ?: get_theme_mod( 'shopco_hero_subtitle', 'Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.' );
    $hero_btn_text = get_field( 'hero_button_text' ) ?: 'Shop Now';
    $hero_btn_link = get_field( 'hero_button_link' );
    $hero_image    = get_field( 'hero_image' );

    if ( ! $hero_btn_link ) {
        $hero_btn_link = class_exists( 'WooCommerce' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '#';
    }
?>
<section class="hero">
    <div class="container">
        <div class="hero__inner">
            <div class="hero__content">
                <h1 class="hero__title">
                    <?php echo esc_html( $hero_title ); ?>
                </h1>
                <p class="hero__subtitle">
                    <?php echo esc_html( $hero_subtitle ); ?>
                </p>
                <a href="<?php echo esc_url( $hero_btn_link ); ?>" class="btn btn--primary hero__btn">
                    <?php echo esc_html( $hero_btn_text ); ?>
                </a>
                <div class="hero__stats">
                    <?php
                    if ( function_exists( 'have_rows' ) && have_rows( 'hero_stats' ) ) :
                        $stat_index = 0;
                        while ( have_rows( 'hero_stats' ) ) : the_row();
                            if ( $stat_index > 0 ) : ?>
                                <div class="hero__stat-divider"></div>
                            <?php endif; ?>
                            <div class="hero__stat">
                                <span class="hero__stat-number"><?php echo esc_html( get_sub_field( 'stat_number' ) ); ?></span>
                                <span class="hero__stat-label"><?php echo esc_html( get_sub_field( 'stat_label' ) ); ?></span>
                            </div>
                            <?php
                            $stat_index++;
                        endwhile;
                    else :
                        // Fallback stats when ACF is not configured
                        $default_stats = array(
                            array( 'number' => '200+', 'label' => 'International Brands' ),
                            array( 'number' => '2,000+', 'label' => 'High-Quality Products' ),
                            array( 'number' => '30,000+', 'label' => 'Happy Customers' ),
                        );
                        foreach ( $default_stats as $i => $stat ) :
                            if ( $i > 0 ) : ?><div class="hero__stat-divider"></div><?php endif; ?>
                            <div class="hero__stat">
                                <span class="hero__stat-number"><?php echo esc_html( $stat['number'] ); ?></span>
                                <span class="hero__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                            </div>
                        <?php endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="hero__image">
                <?php if ( $hero_image ) : ?>
                    <img src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['alt'] ?: 'Fashion models' ); ?>">
                <?php else :
                    $customizer_hero = get_theme_mod( 'shopco_hero_image' );
                    if ( $customizer_hero ) : ?>
                        <img src="<?php echo esc_url( $customizer_hero ); ?>" alt="Fashion models">
                    <?php else : ?>
                        <img src="<?php echo esc_url( SHOPCO_URI . '/assets/images/hero-couple.png' ); ?>" alt="Fashion models">
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Decorative stars -->
                <svg class="hero__star hero__star--large" width="56" height="56" viewBox="0 0 56 56" fill="none">
                    <path d="M28 0L31.5 24.5L56 28L31.5 31.5L28 56L24.5 31.5L0 28L24.5 24.5L28 0Z" fill="black"/>
                </svg>
                <svg class="hero__star hero__star--small" width="36" height="36" viewBox="0 0 56 56" fill="none">
                    <path d="M28 0L31.5 24.5L56 28L31.5 31.5L28 56L24.5 31.5L0 28L24.5 24.5L28 0Z" fill="black"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- ======= BRAND LOGOS BAR ======= -->
<section class="brands">
    <div class="brands__inner">
        <?php
        if ( function_exists( 'have_rows' ) && have_rows( 'brand_logos' ) ) :
            while ( have_rows( 'brand_logos' ) ) : the_row();
                $logo  = get_sub_field( 'brand_logo_image' );
                $name  = get_sub_field( 'brand_logo_name' );
                if ( $logo ) : ?>
                    <div class="brands__logo">
                        <img src="<?php echo esc_url( $logo['url'] ); ?>"
                             alt="<?php echo esc_attr( $name ?: $logo['alt'] ); ?>"
                             width="<?php echo esc_attr( $logo['width'] ); ?>"
                             height="<?php echo esc_attr( $logo['height'] ); ?>"
                             loading="lazy">
                    </div>
                <?php endif;
            endwhile;
        else :
            // Fallback when ACF brand logos are not yet configured
            $fallback_brands = array( 'VERSACE', 'ZARA', 'GUCCI', 'PRADA', 'Calvin Klein' );
            foreach ( $fallback_brands as $brand ) : ?>
                <div class="brands__logo">
                    <span class="brands__logo-text"><?php echo esc_html( $brand ); ?></span>
                </div>
            <?php endforeach;
        endif;
        ?>
    </div>
</section>

<!-- ======= NEW ARRIVALS SECTION ======= -->
<?php
    $na_title     = get_field( 'new_arrivals_title' ) ?: 'NEW ARRIVALS';
    $na_category  = get_field( 'new_arrivals_category' );
    $na_count     = get_field( 'new_arrivals_count' ) ?: 4;
    $na_view_link = get_field( 'new_arrivals_view_all_link' );

    if ( ! $na_view_link && class_exists( 'WooCommerce' ) ) {
        if ( $na_category ) {
            $na_view_link = get_term_link( intval( $na_category ), 'product_cat' );
            if ( is_wp_error( $na_view_link ) ) {
                $na_view_link = get_permalink( wc_get_page_id( 'shop' ) );
            }
        } else {
            $na_view_link = get_permalink( wc_get_page_id( 'shop' ) );
        }
    }
?>
<section class="products-section" id="newArrivals">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html( $na_title ); ?></h2>
        <div class="products-grid">
            <?php
            if ( class_exists( 'WooCommerce' ) ) {
                // Build query args - category is chosen dynamically from ACF
                $query_args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => intval( $na_count ),
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );

                // If a category is selected in ACF, query by that category
                if ( $na_category ) {
                    $query_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => intval( $na_category ),
                        ),
                    );
                }

                $new_products = new WP_Query( $query_args );

                if ( $new_products->have_posts() ) :
                    while ( $new_products->have_posts() ) : $new_products->the_post();
                        global $product;
                        ?>
                        <div class="product-card">
                            <a href="<?php the_permalink(); ?>" class="product-card__image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'shopco-product-card' ); ?>
                                <?php else : ?>
                                    <div class="product-card__placeholder"></div>
                                <?php endif; ?>
                            </a>
                            <div class="product-card__info">
                                <h3 class="product-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php
                                $avg_rating = $product->get_average_rating();
                                echo shopco_star_rating( $avg_rating ? $avg_rating : 4.5 );
                                ?>
                                <div class="product-card__price">
                                    <?php if ( $product->is_on_sale() ) : ?>
                                        <span class="price-current"><?php echo $product->get_sale_price() ? wc_price( $product->get_sale_price() ) : $product->get_price_html(); ?></span>
                                        <span class="price-original"><?php echo wc_price( $product->get_regular_price() ); ?></span>
                                        <?php
                                        $regular = floatval( $product->get_regular_price() );
                                        $sale    = floatval( $product->get_sale_price() );
                                        if ( $regular > 0 ) {
                                            $discount = round( ( ( $regular - $sale ) / $regular ) * 100 );
                                            echo '<span class="price-discount">-' . esc_html( $discount ) . '%</span>';
                                        }
                                        ?>
                                    <?php else : ?>
                                        <span class="price-current"><?php echo $product->get_price_html(); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="products-section__empty">No products found. Add products in WooCommerce and select a category above.</p>
                <?php endif;
            } else { ?>
                <p class="products-section__empty">Please install and activate WooCommerce to display products.</p>
            <?php } ?>
        </div>
        <div class="section-cta">
            <a href="<?php echo esc_url( $na_view_link ?: '#' ); ?>" class="btn btn--outline">
                View All
            </a>
        </div>
        <hr class="section-divider">
    </div>
</section>

<!-- ======= TOP SELLING SECTION ======= -->
<section class="products-section" id="topSelling">
    <div class="container">
        <h2 class="section-title">TOP SELLING</h2>
        <div class="products-grid">
            <?php
            if ( class_exists( 'WooCommerce' ) ) {
                $top_products = new WP_Query( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'meta_key'       => 'total_sales',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                ) );

                if ( $top_products->have_posts() ) :
                    while ( $top_products->have_posts() ) : $top_products->the_post();
                        global $product;
                        ?>
                        <div class="product-card">
                            <a href="<?php the_permalink(); ?>" class="product-card__image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'shopco-product-card' ); ?>
                                <?php else : ?>
                                    <div class="product-card__placeholder"></div>
                                <?php endif; ?>
                            </a>
                            <div class="product-card__info">
                                <h3 class="product-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php
                                $avg_rating = $product->get_average_rating();
                                echo shopco_star_rating( $avg_rating ? $avg_rating : 4 );
                                ?>
                                <div class="product-card__price">
                                    <?php if ( $product->is_on_sale() ) : ?>
                                        <span class="price-current"><?php echo $product->get_sale_price() ? wc_price( $product->get_sale_price() ) : $product->get_price_html(); ?></span>
                                        <span class="price-original"><?php echo wc_price( $product->get_regular_price() ); ?></span>
                                        <?php
                                        $regular = floatval( $product->get_regular_price() );
                                        $sale    = floatval( $product->get_sale_price() );
                                        if ( $regular > 0 ) {
                                            $discount = round( ( ( $regular - $sale ) / $regular ) * 100 );
                                            echo '<span class="price-discount">-' . $discount . '%</span>';
                                        }
                                        ?>
                                    <?php else : ?>
                                        <span class="price-current"><?php echo $product->get_price_html(); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            } else {
                $fallback_top = array(
                    array( 'name' => 'Vertical Striped Shirt', 'rating' => 5, 'price' => '$212', 'old_price' => '$232', 'discount' => '-20%' ),
                    array( 'name' => 'Courage Graphic T-shirt', 'rating' => 4, 'price' => '$145', 'old_price' => '', 'discount' => '' ),
                    array( 'name' => 'Loose Fit Bermuda Shorts', 'rating' => 3, 'price' => '$80', 'old_price' => '', 'discount' => '' ),
                    array( 'name' => 'Faded Skinny Jeans', 'rating' => 4.5, 'price' => '$210', 'old_price' => '', 'discount' => '' ),
                );
                foreach ( $fallback_top as $fp ) {
                    ?>
                    <div class="product-card">
                        <div class="product-card__image">
                            <div class="product-card__placeholder"></div>
                        </div>
                        <div class="product-card__info">
                            <h3 class="product-card__title"><?php echo esc_html( $fp['name'] ); ?></h3>
                            <?php echo shopco_star_rating( $fp['rating'] ); ?>
                            <div class="product-card__price">
                                <span class="price-current"><?php echo esc_html( $fp['price'] ); ?></span>
                                <?php if ( $fp['old_price'] ) : ?>
                                    <span class="price-original"><?php echo esc_html( $fp['old_price'] ); ?></span>
                                    <span class="price-discount"><?php echo esc_html( $fp['discount'] ); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="section-cta">
            <a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) : '#'; ?>" class="btn btn--outline">
                View All
            </a>
        </div>
    </div>
</section>

<!-- ======= BROWSE BY DRESS STYLE ======= -->
<section class="browse-style">
    <div class="container">
        <div class="browse-style__inner">
            <h2 class="section-title">BROWSE BY DRESS STYLE</h2>
            <div class="browse-style__grid">
                <?php
                $styles = array(
                    array( 'name' => 'Casual', 'slug' => 'casual', 'class' => 'browse-style__card--casual' ),
                    array( 'name' => 'Formal', 'slug' => 'formal', 'class' => 'browse-style__card--formal' ),
                    array( 'name' => 'Party', 'slug' => 'party', 'class' => 'browse-style__card--party' ),
                    array( 'name' => 'Gym', 'slug' => 'gym', 'class' => 'browse-style__card--gym' ),
                );
                foreach ( $styles as $style ) :
                    $link = '#';
                    if ( class_exists( 'WooCommerce' ) ) {
                        $term = get_term_by( 'slug', $style['slug'], 'product_cat' );
                        if ( $term ) {
                            $link = get_term_link( $term );
                        }
                    }
                    // Get background image from Customizer
                    $style_image = get_theme_mod( 'shopco_style_image_' . $style['slug'], '' );
                    $inline_style = '';
                    if ( $style_image ) {
                        $inline_style = 'background-image: url(' . esc_url( $style_image ) . '); background-size: cover; background-position: right center;';
                    }
                    ?>
                    <a href="<?php echo esc_url( $link ); ?>" class="browse-style__card <?php echo esc_attr( $style['class'] ); ?>"<?php echo $inline_style ? ' style="' . esc_attr( $inline_style ) . '"' : ''; ?>>
                        <h3 class="browse-style__card-title"><?php echo esc_html( $style['name'] ); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ======= HAPPY CUSTOMERS / TESTIMONIALS ======= -->
<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="testimonials__header">
            <h2 class="section-title section-title--left">OUR HAPPY CUSTOMERS</h2>
            <div class="testimonials__nav">
                <button class="testimonials__arrow testimonials__arrow--prev" id="testimonialPrev" aria-label="Previous">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="testimonials__arrow testimonials__arrow--next" id="testimonialNext" aria-label="Next">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="testimonials__slider" id="testimonialSlider">
            <div class="testimonials__track">
                <?php
                $testimonials = array(
                    array(
                        'name'   => 'Sarah M.',
                        'rating' => 5,
                        'text'   => "I'm blown away by the quality and style of the clothes I received from ShopCo. From casual wear to elegant dresses, every piece I've bought has exceeded my expectations.",
                    ),
                    array(
                        'name'   => 'Alex K.',
                        'rating' => 5,
                        'text'   => "Finding clothes that align with my personal style used to be a challenge until I discovered ShopCo. The range of options they offer is truly remarkable, catering to a variety of tastes and occasions.",
                    ),
                    array(
                        'name'   => 'James L.',
                        'rating' => 5,
                        'text'   => "As someone who's always on the lookout for unique fashion pieces, I'm thrilled to have stumbled upon ShopCo. The selection of clothes is not only diverse but also on-point with the latest trends.",
                    ),
                    array(
                        'name'   => 'Mooen',
                        'rating' => 5,
                        'text'   => "The quality of the products exceeded my expectations. Every item I purchased fits perfectly and looks amazing. ShopCo has become my go-to destination for all my fashion needs.",
                    ),
                    array(
                        'name'   => 'Priya S.',
                        'rating' => 5,
                        'text'   => "ShopCo transformed my wardrobe completely. The attention to detail in each garment is remarkable. I receive compliments every time I wear something from their collection.",
                    ),
                );
                foreach ( $testimonials as $t ) :
                    ?>
                    <div class="testimonial-card">
                        <div class="testimonial-card__rating">
                            <?php for ( $i = 0; $i < $t['rating']; $i++ ) : ?>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="#FFC633">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <div class="testimonial-card__author">
                            <span class="testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></span>
                            <svg class="testimonial-card__verified" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <circle cx="10" cy="10" r="10" fill="#01AB31"/>
                                <path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="testimonial-card__text">"<?php echo esc_html( $t['text'] ); ?>"</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ======= NEWSLETTER SECTION ======= -->
<section class="newsletter">
    <div class="container">
        <div class="newsletter__inner">
            <h2 class="newsletter__title">
                <?php echo esc_html( get_theme_mod( 'shopco_newsletter_title', 'STAY UP TO DATE ABOUT OUR LATEST OFFERS' ) ); ?>
            </h2>
            <form class="newsletter__form" action="#" method="post">
                <div class="newsletter__input-wrapper">
                    <svg class="newsletter__icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                        <path d="M22 6L12 13L2 6" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="email" name="email" placeholder="Enter your email address" required>
                </div>
                <button type="submit" class="btn btn--white newsletter__btn">
                    Subscribe to Newsletter
                </button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
