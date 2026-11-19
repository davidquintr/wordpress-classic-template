<?php
/**
 * Comments list and form, loaded by comments_template() from single.php.
 * Styles: styles/parts/comments.css
 */
?>
<article class="comment-area">
    <?php if (!have_comments()) : ?>
        <header>
            <h2><?php esc_html_e('Leave a comment', 'wordpress-classic-template'); ?></h2>
        </header>
    <?php endif; ?>

    <?php
    wp_list_comments(array(
        'avatar_size' => 120,
        'style'       => 'div',
    ));

    if (comments_open()) {
        comment_form(array(
            'title_reply_before' => '<h2 class="comment-reply-title">',
            'title_reply_after'  => '</h2>',
        ));
    }
    ?>
</article>
