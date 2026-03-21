<?php
/**
 * WooCommerce shop page wrapper template
 * This overrides the default WooCommerce template wrapping
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container">
        <?php woocommerce_content(); ?>
    </div>
</main>

<?php get_footer(); ?>
