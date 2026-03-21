<?php
/**
 * Custom My Account Navigation
 * Overrides woocommerce/myaccount/navigation.php
 *
 * @package ShopCo
 */

defined( 'ABSPATH' ) || exit;

// Icon map for each menu item
$icons = array(
    'dashboard'       => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
    'orders'          => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>',
    'downloads'       => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>',
    'edit-address'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>',
    'edit-account'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
    'customer-logout' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>',
);

do_action( 'woocommerce_before_account_navigation' );
?>

<ul class="myaccount-nav__list">
    <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
        $icon = isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ] : '';
        $is_active = wc_is_current_account_menu_item( $endpoint );
        $is_logout = ( $endpoint === 'customer-logout' );
        ?>
        <li class="myaccount-nav__item <?php echo $is_active ? 'myaccount-nav__item--active' : ''; ?> <?php echo $is_logout ? 'myaccount-nav__item--logout' : ''; ?>">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="myaccount-nav__link">
                <?php if ( $icon ) echo $icon; ?>
                <span><?php echo esc_html( $label ); ?></span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
