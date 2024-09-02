<?php
$product = wc_get_product(get_the_ID());

if ($product->is_type('variable')) {
    $available_variations = $product->get_available_variations();

    foreach ($available_variations as $variation) {
        // Obtener la URL y el ID de la imagen de la variación
        $variation_id = $variation['variation_id'];
        $variation_product = wc_get_product($variation_id);
        $variation_thumbnail_id = $variation_product->get_image_id();
        $variation_thumbnail_url = wp_get_attachment_url($variation_thumbnail_id);
        $variation_thumbnail_alt = get_post_meta($variation_thumbnail_id, '_wp_attachment_image_alt', true);

        // Usar la miniatura del producto principal si la variación no tiene imagen
        if (!$variation_thumbnail_url) {
            $variation_thumbnail_url = get_the_post_thumbnail_url();
            $variation_thumbnail_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
        }

        // Si no hay imagen disponible, usar una imagen por defecto
        if (!$variation_thumbnail_url) {
            $variation_thumbnail_url = get_template_directory_uri() . '/assets/images/product-no-icon.png';
            $variation_thumbnail_alt = 'No image available';
        }
        ?>

        <li class="product-item">
            <a class="image-link" href="<?php echo esc_url($variation_product->get_permalink()); ?>" aria-label="Product">
                <img src="<?php echo esc_url($variation_thumbnail_url); ?>" alt="<?php echo esc_attr($variation_thumbnail_alt); ?>">
            </a>

            <div class="details">
                <h2 class="title has-tw-cent-mt-std-font-family">
                    <a class="image-link" href="<?php echo esc_url($variation_product->get_permalink()); ?>">
                        <?php echo esc_html($variation_product->get_name()); ?>
                    </a>
                </h2>
                <hr class="separator-tiny">
                <p class="price"><?php echo $variation_product->get_price_html(); ?></p>
            </div>
        </li>

        <?php
    }
} else {
    // Código original para productos simples (sin variaciones)
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = get_the_post_thumbnail_url();
    $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

    if (!$thumbnail_url) {
        $thumbnail_url = get_template_directory_uri() . '/assets/images/product-no-icon.png';
        $thumbnail_alt = 'No image available';
    }
    ?>

    <li class="product-item">
        <a class="image-link" href="<?php the_permalink(); ?>" aria-label="Product">
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($thumbnail_alt); ?>">
        </a>

        <div class="details">
            <h2 class="title has-tw-cent-mt-std-font-family">
                <a class="image-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <hr class="separator-tiny">
            <p class="price"><?php echo wc_get_product(get_the_ID())->get_price_html(); ?></p>
        </div>
    </li>

    <?php
}
?>