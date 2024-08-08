<li class="product-item">
    <a class="image-link" href="<?php the_permalink(); ?>">
        <?php if (get_the_post_thumbnail_url()): ?>
            <img src="<?php echo get_the_post_thumbnail_url(); ?>">
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri() . '/assets/images/product-no-icon.png' ?>">
        <?php endif ?>
    </a>

    <div class="details">
        <h2 class="title has-tw-cent-mt-std-font-family"><a class="image-link"
                href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <hr class="separator-tiny">
        <p class="price"><?php echo wc_get_product(get_the_ID())->get_price_html(); ?></p>
    </div>
</li>