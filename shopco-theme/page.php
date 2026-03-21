<?php
/**
 * Generic page template
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="page-header">
                <h1 class="page-header__title"><?php the_title(); ?></h1>
            </div>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
