<?php
/**
 * Single post template
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="single-post">
                <div class="page-header">
                    <h1 class="page-header__title"><?php the_title(); ?></h1>
                    <p style="color: var(--color-gray-500); margin-top: 8px;">
                        <?php echo get_the_date(); ?> &middot; By <?php the_author(); ?>
                    </p>
                </div>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div style="margin-bottom: 32px; border-radius: var(--radius-xl); overflow: hidden;">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            </article>

            <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
