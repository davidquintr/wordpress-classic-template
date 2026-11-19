<?php
/**
 * Component: Project card (compact version, used by Project Listing).
 * Styles: styles/components/project-card.css
 *
 * $args['project']: WP_Post of type "project".
 */

$project = isset($args['project']) ? get_post($args['project']) : null;

if (!$project) {
    return;
}

$icon = wordpress_classic_template_field('icon', $project->ID);
?>
<a class="project-card" href="<?php echo esc_url(get_permalink($project)); ?>">
    <span class="project-card-glow" aria-hidden="true"></span>
    <div class="project-card-box">
        <div class="project-card-icon">
            <?php
            if (!empty($icon['ID'])) {
                echo wp_get_attachment_image($icon['ID'], 'medium', false, array(
                    'sizes'         => '48px',
                    'loading'       => 'eager',
                    'fetchpriority' => 'high',
                    'alt'           => $icon['alt'] ? $icon['alt'] : $icon['title'],
                ));
            }
            ?>
        </div>
        <h3 class="project-card-title"><?php echo esc_html(get_the_title($project)); ?></h3>
        <span class="project-card-shine" aria-hidden="true"></span>
    </div>
</a>
