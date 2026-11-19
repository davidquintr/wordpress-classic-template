<?php
/**
 * Site footer: closes <main> and renders the fixed bottom navigation.
 * Styles: styles/parts/navigation.css
 *
 * Menu location "primary" (Appearance > Menus). Item icons come from a
 * CSS class "icon-<tabler-name>" on each menu item.
 */
?>
</main>

<?php if (has_nav_menu('primary')) : ?>
    <nav class="site-navigation" aria-label="<?php esc_attr_e('Main navigation', 'wordpress-classic-template'); ?>">
        <div class="site-navigation-items" data-nosnippet>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'depth'          => 1,
                'walker'         => new Wordpress_Classic_Template_Navigation_Walker(),
            ));
            ?>
        </div>
    </nav>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
