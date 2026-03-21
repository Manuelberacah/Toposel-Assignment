<?php
/**
 * Custom product card template for shop loops
 * Overrides woocommerce/content-product.php
 *
 * @package ShopCo
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>

<li <?php wc_product_class( 'product-card', $product ); ?>>
    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-card__image">
        <?php
        if ( $product->is_on_sale() ) {
            $regular = floatval( $product->get_regular_price() );
            $sale    = floatval( $product->get_sale_price() );
            if ( $regular > 0 && $sale > 0 ) {
                $discount = round( ( ( $regular - $sale ) / $regular ) * 100 );
                echo '<span class="product-card__badge price-discount">-' . $discount . '%</span>';
            }
        }
        ?>
        <?php echo $product->get_image( 'shopco-product-card' ); ?>
    </a>

    <div class="product-card__info">
        <h3 class="product-card__title">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                <?php echo esc_html( $product->get_name() ); ?>
            </a>
        </h3>

        <?php
        $rating = $product->get_average_rating();
        echo shopco_star_rating( $rating ? $rating : 4.5 );
        ?>

        <div class="product-card__price">
            <?php if ( $product->is_on_sale() && $product->get_sale_price() ) : ?>
                <span class="price-current"><?php echo wc_price( $product->get_sale_price() ); ?></span>
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
                <span class="price-current"><?php echo wc_price( $product->get_price() ); ?></span>
            <?php endif; ?>
        </div>
    </div>
</li>
