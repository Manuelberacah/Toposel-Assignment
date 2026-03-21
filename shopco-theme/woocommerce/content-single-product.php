<?php
/**
 * Custom Single Product Page
 * Matches SHOP.CO Figma - Gallery + Details + Tabs + Reviews + Related
 *
 * @package ShopCo
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}

$product_id    = $product->get_id();
$gallery_ids   = $product->get_gallery_image_ids();
$main_image_id = $product->get_image_id();
$all_images    = array();
if ( $main_image_id ) $all_images[] = $main_image_id;
$all_images    = array_merge( $all_images, $gallery_ids );
?>

<!-- Breadcrumb -->
<nav class="shopco-breadcrumb">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">Shop</a>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
    <?php
    $cats = get_the_terms( $product_id, 'product_cat' );
    if ( $cats && ! is_wp_error( $cats ) ) :
        $cat = $cats[0]; ?>
        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
    <?php endif; ?>
    <span><?php echo esc_html( $product->get_name() ); ?></span>
</nav>

<div class="shopco-single-product" id="product-<?php the_ID(); ?>">

    <!-- ===== ROW 1: Gallery + Details (side by side) ===== -->
    <div class="sp-top">
        <!-- Image Gallery -->
        <div class="sp-gallery">
            <div class="sp-gallery__thumbs">
                <?php foreach ( $all_images as $idx => $img_id ) :
                    $thumb_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
                    $full_url  = wp_get_attachment_image_url( $img_id, 'large' );
                    ?>
                    <button class="sp-gallery__thumb <?php echo $idx === 0 ? 'sp-gallery__thumb--active' : ''; ?>"
                            data-index="<?php echo $idx; ?>"
                            data-full="<?php echo esc_url( $full_url ); ?>">
                        <img src="<?php echo esc_url( $thumb_url ); ?>" alt="">
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="sp-gallery__main">
                <?php if ( $main_image_id ) : ?>
                    <img id="spMainImage" src="<?php echo esc_url( wp_get_attachment_image_url( $main_image_id, 'large' ) ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>">
                <?php else : ?>
                    <div style="width:100%;height:100%;min-height:400px;background:#F0F0F0;border-radius:20px;"></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="sp-details">
            <h1 class="sp-details__title"><?php echo esc_html( $product->get_name() ); ?></h1>

            <div class="sp-details__rating">
                <?php echo shopco_star_rating( $product->get_average_rating() ?: 4.5 ); ?>
            </div>

            <div class="sp-details__price">
                <?php if ( $product->is_on_sale() ) : ?>
                    <span class="sp-price"><?php echo wc_price( $product->get_sale_price() ); ?></span>
                    <span class="sp-price sp-price--old"><?php echo wc_price( $product->get_regular_price() ); ?></span>
                    <?php
                    $r = floatval( $product->get_regular_price() );
                    $s = floatval( $product->get_sale_price() );
                    if ( $r > 0 ) echo '<span class="price-discount">-' . round( ( ( $r - $s ) / $r ) * 100 ) . '%</span>';
                    ?>
                <?php else : ?>
                    <span class="sp-price"><?php echo wc_price( $product->get_price() ); ?></span>
                <?php endif; ?>
            </div>

            <?php if ( $product->get_short_description() ) : ?>
                <div class="sp-details__desc"><?php echo wpautop( $product->get_short_description() ); ?></div>
            <?php endif; ?>

            <hr class="sp-details__hr">

            <?php
            // Color attribute
            $color_attr = $product->get_attribute( 'pa_color' );
            if ( $color_attr ) :
                $colors = array_map( 'trim', explode( ',', $color_attr ) );
                $hex_map = array( 'black'=>'#000','white'=>'#fff','red'=>'#f00','blue'=>'#00f','green'=>'#0c0','olive'=>'#4F4631','navy'=>'#001f3f','brown'=>'#8B4513','gray'=>'#888','yellow'=>'#ff0','orange'=>'#f80','purple'=>'#800080','pink'=>'#ff69b4','teal'=>'#008080' );
                ?>
                <div class="sp-details__option">
                    <span class="sp-details__label">Select Colors</span>
                    <div class="sp-colors">
                        <?php foreach ( $colors as $i => $c ) :
                            $hex = isset( $hex_map[ strtolower( $c ) ] ) ? $hex_map[ strtolower( $c ) ] : '#888';
                            ?>
                            <label class="sp-color <?php echo $i === 0 ? 'sp-color--active' : ''; ?>" style="background:<?php echo esc_attr( $hex ); ?>;" title="<?php echo esc_attr( $c ); ?>">
                                <input type="radio" name="sp_color" value="<?php echo esc_attr( $c ); ?>" <?php echo $i === 0 ? 'checked' : ''; ?>>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7l3 3 5-5" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            // Size attribute
            $size_attr = $product->get_attribute( 'pa_size' );
            if ( $size_attr ) :
                $sizes = array_map( 'trim', explode( ',', $size_attr ) );
                ?>
                <div class="sp-details__option">
                    <span class="sp-details__label">Choose Size</span>
                    <div class="sp-sizes">
                        <?php foreach ( $sizes as $i => $sz ) : ?>
                            <label class="sp-size <?php echo $i === 2 ? 'sp-size--active' : ''; ?>">
                                <input type="radio" name="sp_size" value="<?php echo esc_attr( $sz ); ?>" <?php echo $i === 2 ? 'checked' : ''; ?>>
                                <span><?php echo esc_html( $sz ); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <hr class="sp-details__hr">

            <div class="sp-addtocart">
                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>
        </div>
    </div>

    <!-- ===== ROW 2: TABS (full width below) ===== -->
    <div class="sp-tabs">
        <div class="sp-tabs__nav">
            <button class="sp-tabs__btn" data-tab="details">Product Details</button>
            <button class="sp-tabs__btn sp-tabs__btn--active" data-tab="reviews">Rating & Reviews</button>
            <button class="sp-tabs__btn" data-tab="faqs">FAQs</button>
        </div>

        <div class="sp-tabs__panel" id="sp-tab-details" style="display:none;">
            <?php the_content(); ?>
            <?php if ( $product->has_attributes() ) wc_display_product_attributes( $product ); ?>
        </div>

        <div class="sp-tabs__panel sp-tabs__panel--active" id="sp-tab-reviews">
            <div class="sp-reviews-header">
                <h3 class="sp-reviews-title">All Reviews <span style="font-weight:400;color:#999;">(<?php echo $product->get_review_count(); ?>)</span></h3>
                <div class="sp-reviews-actions">
                    <select class="sp-reviews-sort"><option>Latest</option><option>Highest Rated</option></select>
                    <a href="#review_form" class="btn btn--primary" style="padding:10px 20px;font-size:14px;">Write a Review</a>
                </div>
            </div>

            <div class="sp-reviews-grid">
                <?php
                $reviews = get_comments( array( 'post_id' => $product_id, 'status' => 'approve', 'type' => 'review', 'number' => 6 ) );
                if ( $reviews ) :
                    foreach ( $reviews as $review ) :
                        $rating = intval( get_comment_meta( $review->comment_ID, 'rating', true ) );
                        ?>
                        <div class="sp-review-card">
                            <div style="display:flex;gap:2px;margin-bottom:10px;">
                                <?php for ( $i = 0; $i < 5; $i++ ) : ?>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="<?php echo $i < $rating ? '#FFC633' : '#D9D9D9'; ?>"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <?php endfor; ?>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;margin-bottom:10px;">
                                <strong><?php echo esc_html( $review->comment_author ); ?></strong>
                                <svg width="16" height="16" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10" fill="#01AB31"/><path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                            </div>
                            <p style="font-size:15px;line-height:1.6;color:#666;margin-bottom:14px;">"<?php echo esc_html( $review->comment_content ); ?>"</p>
                            <p style="font-size:13px;color:#999;">Posted on <?php echo date( 'F j, Y', strtotime( $review->comment_date ) ); ?></p>
                        </div>
                    <?php endforeach;
                else : ?>
                    <p style="grid-column:1/-1;text-align:center;color:#999;padding:40px;">No reviews yet. Be the first to review this product!</p>
                <?php endif; ?>
            </div>

            <div style="margin-top:40px;">
                <?php comments_template(); ?>
            </div>
        </div>

        <div class="sp-tabs__panel" id="sp-tab-faqs" style="display:none;">
            <p>No FAQs available for this product yet.</p>
        </div>
    </div>

    <!-- ===== ROW 3: RELATED PRODUCTS ===== -->
    <?php
    $related_ids = wc_get_related_products( $product_id, 4 );
    if ( $related_ids ) :
        ?>
        <div class="sp-related">
            <h2 class="section-title">YOU MIGHT ALSO LIKE</h2>
            <div class="products-grid products-grid--4">
                <?php
                $rq = new WP_Query( array( 'post_type' => 'product', 'post__in' => $related_ids, 'posts_per_page' => 4 ) );
                while ( $rq->have_posts() ) : $rq->the_post();
                    global $product; ?>
                    <div class="product-card">
                        <a href="<?php the_permalink(); ?>" class="product-card__image"><?php the_post_thumbnail( 'shopco-product-card' ); ?></a>
                        <div class="product-card__info">
                            <h3 class="product-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php echo shopco_star_rating( $product->get_average_rating() ?: 4 ); ?>
                            <div class="product-card__price">
                                <?php if ( $product->is_on_sale() ) : ?>
                                    <span class="price-current"><?php echo wc_price( $product->get_sale_price() ); ?></span>
                                    <span class="price-original"><?php echo wc_price( $product->get_regular_price() ); ?></span>
                                <?php else : ?>
                                    <span class="price-current"><?php echo wc_price( $product->get_price() ); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
