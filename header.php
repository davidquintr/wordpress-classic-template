<?php
$custom_logo_id = get_theme_mod('custom_logo');
$image_url = wp_get_attachment_image_url($custom_logo_id, 'full');
$uri =  get_template_directory_uri();

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
    <header class="page-header">
        <div class="inner-content">
            <div class="">
                <a href="/" class="page-identity">
                    <img class="icon" src="<?php echo esc_url($image_url); ?>" alt="<?php bloginfo('name'); ?>">
                    <h1 class="name has-tw-cent-mt-std-font-family">
                        <?php echo bloginfo('name'); ?>
                    </h1>
                </a>
            </div>
            <?php
            wp_nav_menu(
                array(
                    'menu' => 'primary',
                    'theme_location' => 'primary',
                    'container' => '',
                    'items_wrap' => '<ul class="menu-items">%3$s</ul>'
                )
            );
            ?>
            <div class="control-buttons">
                <button class="header-button-img">
                    <img src="<?php echo $uri . "/assets/svg/person.svg" ?>" >
                </button>
                <button class="header-button gray-color">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button class="header-button-img image-only">
                    <img src="<?php echo $uri . "/assets/svg/bag.svg" ?>" >
                </button>
            </div>
        </div>
    </header>
    <main class="wp-block-query has-global-padding is-layout-constrained wp-block-query-is-layout-constrained">