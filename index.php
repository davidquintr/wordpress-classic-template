<?php
    get_header();
?>

<article class="">

    <ul class="flex gap-2">
        <?php
            // Define query arguments to get WooCommerce products
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 10, // Change this number to control the number of products displayed
            );

            // The Query
            $loop = new WP_Query($args);

            // The Loop
            if ($loop->have_posts()) {
                while ($loop->have_posts()) {
                    $loop->the_post();
                    wc_get_template_part('content', 'product');
                }
            } else {
                echo __('No products found');
            }

            // Restore original Post Data
            wp_reset_postdata();
        ?>
    </ul>

</article>

<?php
    get_footer();
?>
