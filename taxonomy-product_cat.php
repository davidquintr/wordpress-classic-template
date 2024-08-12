<!-- /wp-content/themes/improvedtheme-wp/taxonomy-product_cat.php -->

<?php
get_header();
?>

<article class="alignwide shop-product-category">
    <?php
    // Función para mostrar productos de una categoría específica
    function display_products_by_category($category) {
        // Verificar si los parámetros de orden y filtro están definidos
        $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';
        $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'DESC';
        $min_price = isset($_GET['min_price']) ? sanitize_text_field($_GET['min_price']) : '';
        $max_price = isset($_GET['max_price']) ? sanitize_text_field($_GET['max_price']) : '';

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $category->term_id,
                    'include_children' => false,
                ),
            ),
            'meta_query' => array(),
            'orderby' => $orderby,
            'order' => $order,
        );

        // Filtrar por precio si los parámetros están definidos
        if ($min_price !== '' && $max_price !== '') {
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC',
            );
        }

        // Consulta de productos
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

    // Función para mostrar una categoría y sus subcategorías
    function display_category_with_subcategories($category) {
        // Mostrar nombre de la categoría
        // Mostrar opciones de orden y filtro
        ?>
        <form method="GET" class="product-sorting">
            <select class="select-sort" name="orderby">
                <option value="date">Order by Date</option>
                <option value="price" <?php selected(isset($_GET['orderby']) && $_GET['orderby'] === 'price'); ?>>Order by Price</option>
            </select>
            <select class="select-sort" name="order">
                <option value="asc" <?php selected(isset($_GET['order']) && $_GET['order'] === 'asc'); ?>>Ascending Order</option>
                <option value="desc" <?php selected(isset($_GET['order']) && $_GET['order'] === 'desc'); ?>>Descending Order</option>
            </select>
            <div class="input-sort">
                <label for="min_price">Minimum Price</label>
                <div class="format">
                    <button class="minus" type="button">-</button>
                    <input class="spinner-target" min="0" type="number" name="min_price" value="<?php echo esc_attr($_GET['min_price'] ?? '0'); ?>">
                    <button class="plus" type="button">+</button>
                </div>
            </div>
            <div class="input-sort">
                <label for="max_price">Maximum Price</label>
                <div class="format">
                    <button class="minus" type="button">-</button>
                    <input class="spinner-target" type="number" min="0" name="max_price" value="<?php echo esc_attr($_GET['max_price'] ?? '4000'); ?>">
                    <button class="plus" type="button">+</button>
                </div>
            </div>
            <button type="submit">Filter</button>
        </form>
        <?php
        echo '<div class="products-in-cat">';
        echo '<h1>' . esc_html($category->name) . '</h1>';
        // Mostrar productos de la categoría
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
                echo '<h2 class="subcategory">' . esc_html($subcategory->name) . '</h2>';
                display_products_by_category($subcategory);
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
