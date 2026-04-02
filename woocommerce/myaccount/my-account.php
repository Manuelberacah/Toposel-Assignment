<?php
/**
 * Custom My Account page layout
 * Overrides woocommerce/myaccount/my-account.php
 *
 * @package ShopCo
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
?>

<div class="myaccount-layout">
    <aside class="myaccount-sidebar">
        <div class="myaccount-sidebar__user">
            <div class="myaccount-sidebar__avatar">
                <?php echo get_avatar( $current_user->ID, 64 ); ?>
            </div>
            <div class="myaccount-sidebar__info">
                <h3 class="myaccount-sidebar__name"><?php echo esc_html( $current_user->display_name ); ?></h3>
                <p class="myaccount-sidebar__email"><?php echo esc_html( $current_user->user_email ); ?></p>
            </div>
        </div>
        <nav class="myaccount-nav">
            <?php wc_get_template( 'myaccount/navigation.php' ); ?>
        </nav>
    </aside>
    <div class="myaccount-content">
        <?php
            /**
             * My Account content - uses standard WC hook
             */
            do_action( 'woocommerce_account_content' );
        ?>
    </div>
</div>
