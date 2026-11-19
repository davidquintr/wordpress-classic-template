
<li class="post-item">
    <a class="post-item-link" href="<?php the_permalink()?>">
        <?php the_post_thumbnail("medium", array("class" => "post-item-image")); ?>
        <div class="post-item-body">
            <h3 class="post-item-title"><?php the_title() ?></h3>
            <p class="post-item-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 12)); ?></p>
        </div>
    </a>
</li>