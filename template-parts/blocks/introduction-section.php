<?php
/**
 * Block: Introduction Section (ACF layout "introduction_section").
 * Styles: styles/blocks/introduction-section.css
 *
 * The first block of a page renders its title as the page <h1>.
 */

$title       = get_sub_field('title');
$description = get_sub_field('description');
$heading     = (isset($args['index']) && $args['index'] === 0) ? 'h1' : 'h2';
?>
<section class="block-introduction">
    <div class="block-introduction-inner">
        <?php if ($title) : ?>
            <<?php echo $heading; ?> class="block-introduction-title"><?php echo esc_html($title); ?></<?php echo $heading; ?>>
        <?php endif; ?>

        <?php if ($description) : ?>
            <div class="block-introduction-description rich-text">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
