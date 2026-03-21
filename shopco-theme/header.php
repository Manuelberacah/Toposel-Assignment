<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Top Promo Banner -->
<div class="top-banner" id="topBanner">
    <div class="container">
        <p class="top-banner__text">
            <?php echo esc_html( get_theme_mod( 'shopco_banner_text', 'Sign up and get 20% off to your first order.' ) ); ?>
            <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="top-banner__link">
                <?php echo esc_html( get_theme_mod( 'shopco_banner_link_text', 'Sign Up Now' ) ); ?>
            </a>
        </p>
        <button class="top-banner__close" id="closeBanner" aria-label="Close banner">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M1 1L13 13M1 13L13 1" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
</div>

<!-- Site Header -->
<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header__inner">
            <!-- Mobile Menu Toggle -->
            <button class="header__menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M3 12H21M3 6H21M3 18H21" stroke="black" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>

            <!-- Logo -->
            <div class="header__logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-text">
                        SHOP.CO
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation -->
            <nav class="header__nav" id="primaryNav">
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'nav-menu',
                        'walker'         => new ShopCo_Nav_Walker(),
                        'fallback_cb'    => false,
                    ) );
                } else {
                    // Fallback menu matching design
                    ?>
                    <ul class="nav-menu">
                        <li class="menu-item menu-item-has-children">
                            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="nav-link">
                                Shop <svg width="10" height="6" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo esc_url( home_url( '/on-sale/' ) ); ?>" class="nav-link">On Sale</a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo esc_url( home_url( '/new-arrivals/' ) ); ?>" class="nav-link">New Arrivals</a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo esc_url( home_url( '/brands/' ) ); ?>" class="nav-link">Brands</a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </nav>

            <!-- Search Bar -->
            <div class="header__search">
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#999" stroke-width="2"/>
                        <path d="M21 21L16.65 16.65" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="search" name="s" placeholder="Search for products..."
                           value="<?php echo esc_attr( get_search_query() ); ?>"
                           <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                           <?php endif; ?>
                    >
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                        <input type="hidden" name="post_type" value="product">
                    <?php endif; ?>
                </form>
            </div>

            <!-- Header Actions (Cart + Account) -->
            <div class="header__actions">
                <!-- Search toggle for mobile -->
                <button class="header__search-toggle" id="searchToggle" aria-label="Search">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="black" stroke-width="2"/>
                        <path d="M21 21L16.65 16.65" stroke="black" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <!-- Cart -->
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header__cart" aria-label="Cart">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="black" stroke-width="2"/>
                        <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="black" stroke-width="2"/>
                        <path d="M1 1H5L7.68 14.39C7.77 14.8504 8.02 15.264 8.38 15.5583C8.74 15.8526 9.19 16.0084 9.66 16H19.4C19.8693 16.0084 20.3208 15.8526 20.6809 15.5583C21.0409 15.264 21.2906 14.8504 21.38 14.39L23 6H6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
                <?php endif; ?>

                <!-- Account -->
                <a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( wc_get_account_endpoint_url( 'dashboard' ) ) : esc_url( wp_login_url() ); ?>" class="header__account" aria-label="Account">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="black" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="black" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Search (hidden by default) -->
    <div class="header__mobile-search" id="mobileSearch">
        <div class="container">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#999" stroke-width="2"/>
                    <path d="M21 21L16.65 16.65" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="search" name="s" placeholder="Search for products...">
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <input type="hidden" name="post_type" value="product">
                <?php endif; ?>
            </form>
        </div>
    </div>
</header>

<!-- Mobile Navigation Overlay -->
<div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
<div class="mobile-nav" id="mobileNav">
    <div class="mobile-nav__header">
        <span class="logo-text">SHOP.CO</span>
        <button class="mobile-nav__close" id="mobileNavClose" aria-label="Close menu">
            <svg width="20" height="20" viewBox="0 0 14 14" fill="none">
                <path d="M1 1L13 13M1 13L13 1" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
    <?php
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'mobile-nav__menu',
            'fallback_cb'    => false,
        ) );
    } else {
        ?>
        <ul class="mobile-nav__menu">
            <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">Shop</a></li>
            <li><a href="<?php echo esc_url( home_url( '/on-sale/' ) ); ?>">On Sale</a></li>
            <li><a href="<?php echo esc_url( home_url( '/new-arrivals/' ) ); ?>">New Arrivals</a></li>
            <li><a href="<?php echo esc_url( home_url( '/brands/' ) ); ?>">Brands</a></li>
        </ul>
        <?php
    }
    ?>
</div>
