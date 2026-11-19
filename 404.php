<?php
/**
 * Not found.
 * Styles: styles/templates/404.css
 */

get_header();
?>

<section class="template-404">
    <h1 class="template-404-title"><?php esc_html_e('Page not found', 'wordpress-classic-template'); ?></h1>
    <p><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back to home', 'wordpress-classic-template'); ?></a></p>
</section>

<?php
get_footer();
