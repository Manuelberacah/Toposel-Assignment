<?php
/**
 * 404 template
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container text-center" style="padding: 100px 0;">
        <h1 style="font-family: var(--font-heading); font-size: 120px; font-weight: 900;">404</h1>
        <p style="font-size: 20px; color: var(--color-gray-500); margin: 16px 0 40px;">
            Oops! The page you're looking for doesn't exist.
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
            Back to Homepage
        </a>
    </div>
</main>

<?php get_footer(); ?>
