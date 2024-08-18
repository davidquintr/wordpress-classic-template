<li class="product-item">
    <a class="image-link" href="<?php the_permalink(); ?>" aria-label="Product">
        <?php 
        $thumbnail_id = get_post_thumbnail_id();
        $thumbnail_url = get_the_post_thumbnail_url();
        $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

        if ($thumbnail_url): ?>
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($thumbnail_alt); ?>">
        <?php else: ?>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/product-no-icon.png'); ?>" alt="No image available">
        <?php endif; ?>
    </a>

    <div class="details">
        <h2 class="title has-tw-cent-mt-std-font-family">
            <a class="image-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <hr class="separator-tiny">
        <p class="price"><?php echo wc_get_product(get_the_ID())->get_price_html(); ?></p>
    </div>
</li>
