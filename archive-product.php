<?php
    get_header();
?>

<article class="alignwide shop-page">
    <h1>Shop</h1>
    <ul class="products-wrapper">
        <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
            );

            // The Query
            $loop = new WP_Query($args);

            // The Loop
            if ($loop->have_posts()) {
                while ($loop->have_posts()) {
                    $loop->the_post();
                    get_template_part('template-parts/content', 'product');
                }
            } else {
                echo __('No products found');
            }
            wp_reset_postdata();
        ?>
    </ul>
</article>

<?php
    get_footer();
?>
