<?php
/**
 * Default page template. Renders the page's ACF blocks, or its content.
 * Styles: styles/templates/page.css
 */

get_header();

while (have_posts()) :
    the_post();

    if (!wordpress_classic_template_render_blocks()) : ?>
        <article class="template-content">
            <h1 class="template-content-title"><?php the_title(); ?></h1>
            <div class="rich-text"><?php the_content(); ?></div>
        </article>
    <?php endif;
endwhile;

get_footer();
