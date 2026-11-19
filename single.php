<?php
/**
 * Single post (and custom post types without their own template).
 * Styles: styles/templates/single.css
 */

get_header();

while (have_posts()) :
    the_post();
    ?>
    <article <?php post_class('template-single'); ?>>
        <header class="template-single-header">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('class' => 'template-single-image')); ?>
            <?php endif; ?>
            <h1 class="template-single-title"><?php the_title(); ?></h1>
            <p class="template-single-date"><?php echo esc_html(get_the_date()); ?></p>
            <?php
            $tag_icon = wordpress_classic_template_icon('tag');
            the_tags('<div class="template-single-tags"><span class="tag">' . $tag_icon, '</span><span class="tag">' . $tag_icon, '</span></div>');
            ?>
        </header>

        <div class="template-single-content rich-text"><?php the_content(); ?></div>

        <?php
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </article>
    <?php
endwhile;

get_footer();
