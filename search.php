<?php
/**
 * Search results template
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container">
        <div class="page-header">
            <h1 class="page-header__title">
                Search results for: "<?php echo esc_html( get_search_query() ); ?>"
            </h1>
        </div>

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

            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <div class="text-center" style="padding: 80px 0;">
                <h2>No results found</h2>
                <p style="color: var(--color-gray-500); margin-top: 8px;">Try searching with different keywords.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
