<?php
/**
 * Archives (categories, tags, dates, authors, post type archives).
 * Styles: styles/templates/archive.css
 */

get_header();
?>

<section class="template-archive">
    <h1 class="template-archive-title"><?php the_archive_title(); ?></h1>
    <?php if (have_posts()) : ?>
        <ul class="template-archive-list">
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'archive');
            endwhile;
            ?>
        </ul>
        <div class="pagination-bar"><?php echo paginate_links(); ?></div>
    <?php endif; ?>
</section>

<?php
get_footer();
