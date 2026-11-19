<?php
/**
 * Fallback template (blog index and anything without a specific template).
 * Styles: styles/templates/index.css
 */

get_header();
?>

<section class="template-index">
    <?php if (have_posts()) : ?>
        <ul class="template-index-list">
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'archive');
            endwhile;
            ?>
        </ul>
        <div class="pagination-bar"><?php echo paginate_links(); ?></div>
    <?php else : ?>
        <p class="no-results"><?php esc_html_e('Nothing found.', 'wordpress-classic-template'); ?></p>
    <?php endif; ?>
</section>

<?php
get_footer();
