<?php
/**
 * Block: Project Listing (ACF layout "project_listing").
 * Styles: styles/blocks/project-listing.css
 * Card:   template-parts/components/project-card.php
 */

$projects = get_sub_field('projects');

if (empty($projects)) {
    return;
}
?>
<ul class="block-project-listing">
    <?php foreach ($projects as $project) : ?>
        <li class="block-project-listing-item">
            <?php get_template_part('template-parts/components/project-card', null, array('project' => $project)); ?>
        </li>
    <?php endforeach; ?>
</ul>
