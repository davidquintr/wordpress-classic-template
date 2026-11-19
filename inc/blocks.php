<?php
/**
 * Dynamic page blocks (ACF flexible content "blocks").
 *
 * Each layout is rendered by template-parts/blocks/<layout-name>.php,
 * with underscores turned into dashes, and styled by
 * styles/blocks/<layout-name>.css:
 *
 *   introduction_section -> template-parts/blocks/introduction-section.php
 *   section_heading      -> template-parts/blocks/section-heading.php
 *   project_listing      -> template-parts/blocks/project-listing.php
 *
 * Inside a block template use get_sub_field(); $args['index'] holds the
 * block position on the page.
 *
 * wordpress_classic_template_render_blocks($post_id) renders every block
 * of a post. It returns false when there is nothing to render (no ACF, or
 * no blocks), so templates can fall back to the content.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wordpress_classic_template_render_blocks($post_id = null) {
    if (!function_exists('have_rows')) {
        return false;
    }

    $post_id = $post_id ? $post_id : get_the_ID();

    if (!have_rows('blocks', $post_id)) {
        return false;
    }

    $index = 0;
    while (have_rows('blocks', $post_id)) {
        the_row();
        $layout = str_replace('_', '-', get_row_layout());
        get_template_part('template-parts/blocks/' . $layout, null, array('index' => $index));
        $index++;
    }

    return true;
}
