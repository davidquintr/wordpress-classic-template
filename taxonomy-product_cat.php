<!-- /wp-content/themes/improvedtheme-wp/taxonomy-product_cat.php -->

<?php
include get_template_directory() . '/inc/parse_to_slug.php';
get_header();
?>

<article class="alignwide shop-product-category">
    <?php
    function display_products_by_category($category)
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $category->term_id,
                    'include_children' => false,
                ),
            ),
        );

        $loop = new WP_Query($args);

        // Mostrar productos
        if ($loop->have_posts()) {
            echo '<ul class="products-wrapper">';
            while ($loop->have_posts()) {
                $loop->the_post();
                get_template_part('template-parts/content', 'product-variant');
            }
            echo '</ul>';
        }
        wp_reset_postdata();
    }

    function display_category_with_subcategories($category)
    {
        $subcategories = get_terms(
            array(
                'taxonomy' => 'product_cat',
                'child_of' => $category->term_id,
                'hide_empty' => false,
            )
        );

        ?>
        <div class="product-sorting">
            <p class="product-sort-title"><?php echo $category->name ?>'s Collection</p>
            <?php
            foreach ($subcategories as $subcategory) {
                $child_subcategories = get_terms(
                    array(
                        'taxonomy' => 'product_cat',
                        'child_of' => $subcategory->term_id,
                        'hide_empty' => false,
                    )
                );

                if (!is_wp_error($child_subcategories) && !empty($child_subcategories)) {
                    echo '<details class="main-category-slide">';
                    echo '<summary id="' . parse_to_slug($subcategory->name) . '" class="subcategory parent">' . esc_html($subcategory->name) . '</summary>';

                    echo '<ul class="child-categories">';
                    foreach ($child_subcategories as $child) {
                        echo '<li><a href="#' . parse_to_slug($child->name) . '" class="subcategory">' . esc_html($child->name) . '</a></li>';
                    }
                    echo '</ul>';

                    echo '</details>';
                }
            }
            ?>
            <button class="menu-button-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <?php
        echo '<div class="products-in-cat">';
        echo '<h1 id="' . parse_to_slug($category->name) . '" class="category">' . esc_html($category->name) . '</h1>';
        // Mostrar productos de la categoría
        display_products_by_category($category);
        if (!is_wp_error($subcategories) && !empty($subcategories)) {
            $last_parent = null; 
        
            foreach ($subcategories as $subcategory) {
                $is_parent = $last_parent === $subcategory->parent;       
                echo '<h2 id="' . parse_to_slug($subcategory->name) . '" class="subcategory' . ($is_parent ? ' parent' : '') . '">' . esc_html($subcategory->name) . '</h2>';
                display_products_by_category($subcategory);
                $last_parent = $subcategory->parent; 

            }
        }
        
        echo '</div>';
    }

    $current_category = get_queried_object();
    display_category_with_subcategories($current_category);
    ?>
</article>

<?php
get_footer();
?>