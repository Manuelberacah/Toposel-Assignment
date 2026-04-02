<?php
/**
 * The main template file (fallback)
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container">
        <?php if ( is_home() && ! is_front_page() ) : ?>
            <div class="page-header">
                <h1 class="page-header__title">Blog</h1>
            </div>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
            <div class="blog-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="blog-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="blog-card__image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="blog-card__content">
                            <h2 class="blog-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="blog-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="text-center mt-4">
                <?php the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                ) ); ?>
            </div>
        <?php else : ?>
            <p class="text-center">No posts found.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
