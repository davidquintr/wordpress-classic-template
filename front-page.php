<?php
/**
 * Front page. Renders the ACF blocks of the page set as homepage.
 * Styles: styles/templates/front-page.css
 */

get_header();

while (have_posts()) :
    the_post();

    if (!wordpress_classic_template_render_blocks()) : ?>
        <article class="template-content rich-text"><?php the_content(); ?></article>
    <?php endif;
endwhile;

get_footer();
