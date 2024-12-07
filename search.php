<?php
get_header();
?>

<article class="alignwide search-page">

    <div class="search-controls">
        <form class="search-form" id="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input name="s" type="search" placeholder="Search" value="<?php echo get_search_query(); ?>">
            <button type="submit" class="header-button gray-color search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <?php if (have_posts()): ?>
        <ul class="products-wrapper">
            <?php while (have_posts()):
                the_post(); ?>
                <?php get_template_part('template-parts/content', 'product'); ?>
            <?php endwhile; ?>
        </ul>
        <div class="pagination-bar">
            <?php
            // Añade la paginación si es necesario
            echo paginate_links(
                array(
                    'total' => $wp_query->max_num_pages,
                )
            );
            ?>
        </div>
    <?php else: ?>
        <p class="no-results"><?php _e('No results found.', 'gabsters-domain'); ?></p>
    <?php endif; ?>

</article>

<?php
get_footer();
?>