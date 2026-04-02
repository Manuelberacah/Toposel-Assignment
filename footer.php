<!-- ======= SITE FOOTER ======= -->
<footer class="site-footer">
    <div class="container">
        <div class="footer__inner">
            <!-- Footer Column 1 - Brand -->
            <div class="footer__brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__logo logo-text">SHOP.CO</a>
                <p class="footer__description">
                    We have clothes that suits your style and which you're proud to wear. From women to men.
                </p>
                <div class="footer__social">
                    <a href="#" class="footer__social-link" aria-label="Twitter">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" stroke="white" fill="white"/>
                        </svg>
                    </a>
                    <a href="#" class="footer__social-link" aria-label="Facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                        </svg>
                    </a>
                    <a href="#" class="footer__social-link" aria-label="Instagram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5"/>
                            <circle cx="12" cy="12" r="5"/>
                            <circle cx="17.5" cy="6.5" r="1.5" fill="white" stroke="none"/>
                        </svg>
                    </a>
                    <a href="#" class="footer__social-link" aria-label="Github">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Footer Column 2 - Company -->
            <div class="footer__col">
                <h4 class="footer__heading">COMPANY</h4>
                <?php
                if ( has_nav_menu( 'footer-company' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-company',
                        'container'      => false,
                        'menu_class'     => 'footer__links',
                    ) );
                } else {
                    ?>
                    <ul class="footer__links">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Works</a></li>
                        <li><a href="#">Career</a></li>
                    </ul>
                <?php } ?>
            </div>

            <!-- Footer Column 3 - Help -->
            <div class="footer__col">
                <h4 class="footer__heading">HELP</h4>
                <?php
                if ( has_nav_menu( 'footer-help' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-help',
                        'container'      => false,
                        'menu_class'     => 'footer__links',
                    ) );
                } else {
                    ?>
                    <ul class="footer__links">
                        <li><a href="#">Customer Support</a></li>
                        <li><a href="#">Delivery Details</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                <?php } ?>
            </div>

            <!-- Footer Column 4 - FAQ -->
            <div class="footer__col">
                <h4 class="footer__heading">FAQ</h4>
                <?php
                if ( has_nav_menu( 'footer-faq' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-faq',
                        'container'      => false,
                        'menu_class'     => 'footer__links',
                    ) );
                } else {
                    ?>
                    <ul class="footer__links">
                        <li><a href="#">Account</a></li>
                        <li><a href="#">Manage Deliveries</a></li>
                        <li><a href="#">Orders</a></li>
                        <li><a href="#">Payments</a></li>
                    </ul>
                <?php } ?>
            </div>

            <!-- Footer Column 5 - Resources -->
            <div class="footer__col">
                <h4 class="footer__heading">RESOURCES</h4>
                <?php
                if ( has_nav_menu( 'footer-resources' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-resources',
                        'container'      => false,
                        'menu_class'     => 'footer__links',
                    ) );
                } else {
                    ?>
                    <ul class="footer__links">
                        <li><a href="#">Free eBooks</a></li>
                        <li><a href="#">Development Tutorial</a></li>
                        <li><a href="#">How to - Blog</a></li>
                        <li><a href="#">Youtube Playlist</a></li>
                    </ul>
                <?php } ?>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer__bottom">
            <p class="footer__copyright">
                Shop.co &copy; 2000-<?php echo date( 'Y' ); ?>, All Rights Reserved
            </p>
            <div class="footer__payments">
                <!-- Visa -->
                <span class="payment-badge">
                    <svg width="46" height="30" viewBox="0 0 46 30" fill="none">
                        <rect width="46" height="30" rx="4" fill="white" stroke="#E6E6E6"/>
                        <text x="8" y="20" font-family="Arial" font-size="12" font-weight="bold" fill="#1A1F71">VISA</text>
                    </svg>
                </span>
                <!-- Mastercard -->
                <span class="payment-badge">
                    <svg width="46" height="30" viewBox="0 0 46 30" fill="none">
                        <rect width="46" height="30" rx="4" fill="white" stroke="#E6E6E6"/>
                        <circle cx="18" cy="15" r="7" fill="#EB001B" opacity="0.8"/>
                        <circle cx="28" cy="15" r="7" fill="#F79E1B" opacity="0.8"/>
                    </svg>
                </span>
                <!-- PayPal -->
                <span class="payment-badge">
                    <svg width="46" height="30" viewBox="0 0 46 30" fill="none">
                        <rect width="46" height="30" rx="4" fill="white" stroke="#E6E6E6"/>
                        <text x="6" y="20" font-family="Arial" font-size="10" font-weight="bold" fill="#003087">Pay</text>
                        <text x="24" y="20" font-family="Arial" font-size="10" font-weight="bold" fill="#009CDE">Pal</text>
                    </svg>
                </span>
                <!-- Apple Pay -->
                <span class="payment-badge">
                    <svg width="46" height="30" viewBox="0 0 46 30" fill="none">
                        <rect width="46" height="30" rx="4" fill="white" stroke="#E6E6E6"/>
                        <text x="5" y="20" font-family="Arial" font-size="10" fill="#000">&#63743; Pay</text>
                    </svg>
                </span>
                <!-- Google Pay -->
                <span class="payment-badge">
                    <svg width="46" height="30" viewBox="0 0 46 30" fill="none">
                        <rect width="46" height="30" rx="4" fill="white" stroke="#E6E6E6"/>
                        <text x="5" y="20" font-family="Arial" font-size="10" fill="#5F6368">G Pay</text>
                    </svg>
                </span>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
