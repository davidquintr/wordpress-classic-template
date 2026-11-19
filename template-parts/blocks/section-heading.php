<?php
/**
 * Block: Section Heading (ACF layout "section_heading").
 * Styles: styles/blocks/section-heading.css
 *
 * The links container is always printed, as in the original site: it
 * adds the gap below the text even when there are no links.
 */

$title       = get_sub_field('title');
$description = get_sub_field('description');
?>
<section class="block-section-heading">
    <?php if ($title) : ?>
        <h2 class="block-section-heading-title"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>

    <?php if ($description) : ?>
        <div class="block-section-heading-description rich-text">
            <?php echo wp_kses_post($description); ?>
        </div>
    <?php endif; ?>

    <div class="block-section-heading-links">
        <?php
        if (have_rows('links')) {
            while (have_rows('links')) {
                the_row();
                echo wordpress_classic_template_link(get_sub_field('link'));
            }
        }
        ?>
    </div>
</section>
