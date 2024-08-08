<!-- /wp-content/themes/your-theme/taxonomy-product_cat.php -->

<?php
get_header();
?>

<article class="">
    <?php
    // Función para mostrar productos de una categoría específica
    function display_products_by_category($category) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1, // Obtener todos los productos de la categoría
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $category->term_id,
                    'include_children' => false, // Solo productos directamente en esta categoría
                ),
            ),
        );

        // The Query
        $loop = new WP_Query($args);

        // The Loop
        if ($loop->have_posts()) {
            echo '<ul class="flex gap-2">';
            while ($loop->have_posts()) {
                $loop->the_post();
                // Use the custom template part for displaying products
                get_template_part('template-parts/content', 'product');
            }
            echo '</ul>';
        } else {
            echo __('No products found');
        }

        // Restore original Post Data
        wp_reset_postdata();
    }

    // Función para mostrar una categoría y sus subcategorías
    function display_category_with_subcategories($category) {
        // Mostrar el nombre de la categoría
        echo '<h2>' . $category->name . '</h2>';
        display_products_by_category($category);

        // Obtener subcategorías
        $subcategories = get_terms(array(
            'taxonomy' => 'product_cat',
            'child_of' => $category->term_id,
            'hide_empty' => false,
        ));

        // Mostrar subcategorías y sus productos
        if (!is_wp_error($subcategories) && !empty($subcategories)) {
            foreach ($subcategories as $subcategory) {
                echo '<h3>' . $subcategory->name . '</h3>';
                display_products_by_category($subcategory);
                //display_category_with_subcategories($subcategory);
            }
        }
    }

    // Obtener la categoría actual consultada
    $current_category = get_queried_object();

    // Mostrar la categoría actual y sus subcategorías
    display_category_with_subcategories($current_category);
    ?>
</article>

<?php
get_footer();
?>
