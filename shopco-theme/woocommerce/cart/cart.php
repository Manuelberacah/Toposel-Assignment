<?php
/**
 * Custom Cart Page - Matches SHOP.CO Figma Design
 * Overrides woocommerce/cart/cart.php
 *
 * @package ShopCo
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<!-- Breadcrumb -->
<nav class="shopco-breadcrumb">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#999" stroke-width="2" stroke-linecap="round"/></svg>
    <span>Cart</span>
</nav>

<h1 class="cart-page__title">YOUR CART</h1>

<div class="cart-page__layout">
    <!-- Cart Items -->
    <div class="cart-page__items">
        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    ?>

                    <div class="cart-item" data-key="<?php echo esc_attr( $cart_item_key ); ?>">
                        <!-- Product Image -->
                        <div class="cart-item__image">
                            <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail' ), $cart_item, $cart_item_key );
                            if ( $product_permalink ) {
                                echo '<a href="' . esc_url( $product_permalink ) . '">' . $thumbnail . '</a>';
                            } else {
                                echo $thumbnail;
                            }
                            ?>
                        </div>

                        <!-- Product Details -->
                        <div class="cart-item__details">
                            <div class="cart-item__header">
                                <div class="cart-item__info">
                                    <h3 class="cart-item__name">
                                        <?php
                                        if ( $product_permalink ) {
                                            echo '<a href="' . esc_url( $product_permalink ) . '">' . esc_html( $_product->get_name() ) . '</a>';
                                        } else {
                                            echo esc_html( $_product->get_name() );
                                        }
                                        ?>
                                    </h3>
                                    <?php
                                    // Display variation attributes (Size, Color, etc.)
                                    $item_data = array();
                                    if ( $cart_item['variation_id'] && is_array( $cart_item['variation'] ) ) {
                                        foreach ( $cart_item['variation'] as $attr_name => $attr_value ) {
                                            $taxonomy = str_replace( 'attribute_', '', $attr_name );
                                            $term = get_term_by( 'slug', $attr_value, $taxonomy );
                                            $label = wc_attribute_label( $taxonomy );
                                            $value = $term ? $term->name : $attr_value;
                                            echo '<p class="cart-item__attr"><span class="cart-item__attr-label">' . esc_html( $label ) . ':</span> ' . esc_html( $value ) . '</p>';
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- Delete Button -->
                                <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="cart-item__remove" aria-label="Remove item" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14zM10 11v6M14 11v6" stroke="#FF3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>

                            <!-- Price and Quantity -->
                            <div class="cart-item__footer">
                                <span class="cart-item__price">
                                    <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                </span>
                                <div class="cart-item__quantity">
                                    <button type="button" class="qty-btn qty-minus" aria-label="Decrease">
                                        <svg width="16" height="2" viewBox="0 0 16 2"><rect width="16" height="2" rx="1" fill="black"/></svg>
                                    </button>
                                    <?php
                                    $product_quantity = woocommerce_quantity_input(
                                        array(
                                            'input_name'   => "cart[{$cart_item_key}][qty]",
                                            'input_value'  => $cart_item['quantity'],
                                            'max_value'    => $_product->get_max_purchase_quantity(),
                                            'min_value'    => '0',
                                            'product_name' => $_product->get_name(),
                                        ),
                                        $_product,
                                        false
                                    );
                                    echo $product_quantity;
                                    ?>
                                    <button type="button" class="qty-btn qty-plus" aria-label="Increase">
                                        <svg width="16" height="16" viewBox="0 0 16 16"><rect y="7" width="16" height="2" rx="1" fill="black"/><rect x="7" width="2" height="16" rx="1" fill="black"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
            <?php endforeach; ?>

            <button type="submit" class="btn btn--primary" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" style="display:none;">
                <?php esc_html_e( 'Update cart', 'woocommerce' ); ?>
            </button>

            <?php do_action( 'woocommerce_cart_contents' ); ?>
            <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>
    </div>

    <!-- Order Summary -->
    <div class="cart-page__summary">
        <h2 class="cart-summary__title">Order Summary</h2>

        <div class="cart-summary__row">
            <span>Subtotal</span>
            <span class="cart-summary__value"><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="cart-summary__row cart-summary__row--discount">
                <span>Discount (<?php echo esc_html( $code ); ?>)</span>
                <span class="cart-summary__value cart-summary__value--red"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <div class="cart-summary__row">
                <span>Delivery Fee</span>
                <span class="cart-summary__value"><?php wc_cart_totals_shipping_html(); ?></span>
            </div>
        <?php endif; ?>

        <div class="cart-summary__divider"></div>

        <div class="cart-summary__row cart-summary__row--total">
            <span>Total</span>
            <span class="cart-summary__value cart-summary__value--total"><?php wc_cart_totals_order_total_html(); ?></span>
        </div>

        <!-- Promo Code -->
        <?php if ( wc_coupons_enabled() ) : ?>
            <div class="cart-summary__promo">
                <form class="promo-form" method="post" action="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <div class="promo-form__input-wrapper">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="7" cy="7" r="1" fill="#999"/>
                        </svg>
                        <input type="text" name="coupon_code" class="input-text" placeholder="Add promo code" id="coupon_code">
                    </div>
                    <button type="submit" class="btn btn--primary promo-form__btn" name="apply_coupon" value="Apply">Apply</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Checkout Button -->
        <div class="cart-summary__checkout">
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn--primary cart-summary__checkout-btn">
                Go to Checkout
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M5 12h14M12 5l7 7-7 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
