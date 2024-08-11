<?php
$custom_logo_id = get_theme_mod('custom_logo');
$image_url = wp_get_attachment_image_url($custom_logo_id, 'full');
$uri = get_template_directory_uri();

$user_id = get_current_user_id();
$avatar_url = get_avatar_url($user_id);
$default_avatar_url = get_avatar_url(0);

$user_info = get_userdata($user_id);

$theme_default_avatar = '/assets/svg/person.svg';

$parsed_url = parse_url($avatar_url);
$query_params = [];
if (isset($parsed_url['query'])) {
    parse_str($parsed_url['query'], $query_params);
}
$decoded_avatar_url = isset($query_params['d']) ? urldecode($query_params['d']) : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    wp_head();
    ?>
</head>

<body>
    <header class="page-header on-scroll">
        <div class="inner-content">
            <a href="/" class="page-identity">
                <img class="icon" src="<?php echo esc_url($image_url); ?>" alt="<?php bloginfo('name'); ?>">
                <h1 class="name has-tw-cent-mt-std-font-family">
                    <?php echo bloginfo('name'); ?>
                </h1>
            </a>
            <?php
            wp_nav_menu(
                array(
                    'menu' => 'primary',
                    'theme_location' => 'primary',
                    'container' => '',
                    'items_wrap' => '<ul class="menu-items header">%3$s</ul>'
                )
            );
            ?>
            <div class="control-buttons">
                <div class="search-controls">
                    <form id="search-header">
                        <input name="s" type="search" placeholder="Search">
                    </form>
                    <button class="header-button gray-color search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                <button class="header-button-img user">
                    <?php if (strpos($decoded_avatar_url, $theme_default_avatar) == true): ?>
                        <img src="<?php echo $uri . '/assets/svg/person.svg' ?>" alt="Avatar">
                    <?php else: ?>
                        <img class="full-height" src="<?php echo $avatar_url ?>" alt="Avatar">
                    <?php endif; ?>
                </button>
                <a href="<?php echo wc_get_cart_url() ?>" class="header-button-img image-only">
                    <img src="<?php echo $uri . "/assets/svg/bag.svg" ?>">
                </a>
                <button class="header-button navigation">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>
        </div>
        <div class="profile-options">
            <div class="user-info">
                <picture class="user-image">
                    <?php if (strpos($decoded_avatar_url, $theme_default_avatar) == true): ?>
                        <img src="<?php echo $uri . '/assets/svg/person.svg' ?>" alt="Avatar">
                    <?php else: ?>
                        <img class="full-height" src="<?php echo $avatar_url ?>" alt="Avatar">
                    <?php endif; ?>
                </picture>
                <div class="info-details">
                    <?php if (is_user_logged_in()): ?>
                        <?php if (isset($user_info->first_name)): ?>
                            <span class="username"><?php echo $user_info->first_name . ' ' . $user_info->last_name ?></span>
                        <?php else: ?>
                            <p class="username"><?php echo $user_info->display_name ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="username">Guest User</span>
                    <?php endif; ?>
                    <div class="user-control-buttons">
                        <?php if (is_user_logged_in()): ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                                <?php _e('My Account', 'text-domain'); ?>
                            </a>
                            <a href="<?php echo wp_logout_url(home_url()); ?>">
                                <?php _e('Logout', 'text-domain'); ?>
                            </a>
                        <? else: ?>
                            <a href="<?php echo wp_login_url(home_url()); ?>">
                                <?php _e('Sign In', 'text-domain'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="wp-block-query is-layout-constrained wp-block-query-is-layout-constrained">