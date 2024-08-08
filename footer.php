</main>
<?php
        wp_footer();
    ?>
    <footer class="page-footer">
        <div class="inner-content">
        <p>©<?php echo date("Y") ?> by <?php echo bloginfo('name'); ?></p>
        <?php
            wp_nav_menu(
                array(
                    'menu' => 'footer',
                    'theme_location' => 'footer',
                    'container' => '',
                    'items_wrap' => '<ul class="menu-items footer">%3$s</ul>'
                )
            );
            ?>
        </div>
    </footer>
</body>
</html>