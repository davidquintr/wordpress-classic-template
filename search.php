<?php
/**
 * Search results, paginated. Each result uses
 * template-parts/content-archive.php.
 * Styles: styles/templates/search.css
 */

get_header();
?>

<section class="template-search">

    <div class="search-controls">
        <form class="search-form" id="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input name="s" type="search" placeholder="Search" value="<?php echo get_search_query(); ?>">
            <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Search', 'wordpress-classic-template'); ?>">
                <?php echo wordpress_classic_template_icon('search'); ?>
            </button>
        </form>
    </div>

    <?php if (have_posts()): ?>
        <ul class="search-results">
            <?php while (have_posts()):
                the_post(); ?>
                <?php get_template_part('template-parts/content', 'archive'); ?>
            <?php endwhile; ?>
        </ul>
        <div class="pagination-bar">
            <?php
            echo paginate_links(
                array(
                    'total' => $wp_query->max_num_pages,
                )
            );
            ?>
        </div>
    <?php else: ?>
        <p class="no-results"><?php _e('No results found.', 'wordpress-classic-template'); ?></p>
    <?php endif; ?>

</section>

<?php
get_footer();
?>
