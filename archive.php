<?php
/**
 * Archive template
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container">
        <div class="page-header">
            <h1 class="page-header__title"><?php the_archive_title(); ?></h1>
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
            <p class="text-center">No posts found.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
