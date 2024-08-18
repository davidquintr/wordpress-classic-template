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
            'posts_per_page' => -1, // Obtener todos los productos de la categoría
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $category->term_id,
                    'include_children' => false, // Solo productos directamente en esta categoría
                ),
            ),
        );

        $loop = new WP_Query($args);

        // Mostrar productos
        if ($loop->have_posts()) {
            echo '<ul class="products-wrapper">';
            while ($loop->have_posts()) {
                $loop->the_post();
                // Usar la parte de plantilla personalizada para mostrar productos
                get_template_part('template-parts/content', 'product');
            }
            echo '</ul>';
        }
        // Restaurar datos originales
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
                // Obtener los hijos de la subcategoría actual
                $child_subcategories = get_terms(
                    array(
                        'taxonomy' => 'product_cat',
                        'child_of' => $subcategory->term_id,
                        'hide_empty' => false,
                    )
                );

                // Verificar si la subcategoría tiene hijos
                if (!is_wp_error($child_subcategories) && !empty($child_subcategories)) {
                    // Mostrar el nombre de la subcategoría como H2 solo si tiene hijos
                    echo '<details class="main-category-slide">';
                    echo '<summary id="' . parse_to_slug($subcategory->name) . '" class="subcategory parent">' . esc_html($subcategory->name) . '</summary>';

                    // Mostrar los hijos
                    echo '<ul class="child-categories">';
                    foreach ($child_subcategories as $child) {
                        echo '<li><a href="#' . parse_to_slug($child->name) . '" class="subcategory">' . esc_html($child->name) . '</a></li>';

                        // Aquí puedes añadir lógica para mostrar los productos de la subcategoría hija
                    }
                    echo '</ul>';

                    echo '</details>';
                }
            }
            ?>
        </div>

        <?php
        echo '<div class="products-in-cat">';
        echo '<h1 id="' . parse_to_slug($category->name) . '" class="category">' . esc_html($category->name) . '</h1>';
        // Mostrar productos de la categoría
        display_products_by_category($category);
        $parent = -1;
        if (!is_wp_error($subcategories) && !empty($subcategories)) {
            foreach ($subcategories as $subcategory) {
                echo '<h2 id="' . parse_to_slug($subcategory->name) . '" class="subcategory' . ($parent == $subcategory->parent ? ' parent' : '') . '">' . esc_html($subcategory->name) . '</h2>';
                display_products_by_category($subcategory);
                $parent = $subcategory->parent;
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