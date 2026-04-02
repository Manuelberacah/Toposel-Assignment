<?php
/**
 * WooCommerce shop page wrapper template
 *
 * For shop/archive pages, load the custom archive-product.php template.
 * For other WooCommerce pages (cart, checkout, account), use default content.
 *
 * @package ShopCo
 */

if ( is_shop() || is_product_category() || is_product_tag() ) {
    // Use custom archive template which has its own header/footer
    get_template_part( 'woocommerce/archive-product' );
} else {
    // Cart, checkout, account, single product, etc.
    get_header();
    ?>
    <main class="shopco-main">
        <div class="container">
            <?php woocommerce_content(); ?>
        </div>
    </main>
    <?php
    get_footer();
}
