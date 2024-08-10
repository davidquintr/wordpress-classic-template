<?php

function improvedtheme_theme_support(){
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'improvedtheme_theme_support');


function improvedtheme_menu_support(){
    $locations = array(
        'primary' => "Header",
        'footer' => "Footer"
    );

    register_nav_menus( $locations );
}

add_action( 'init', 'improvedtheme_menu_support');

function improvedtheme_register_styles(){

    $uri =  get_template_directory_uri();
    wp_enqueue_style('styles-basic', $uri . '/style.css', array(), '1.0', 'all');
    //wp_enqueue_style('gabsters-styles', $uri . '/dist/styles.css', array(), '1.0', 'all');
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
}
add_action( 'wp_enqueue_scripts', 'improvedtheme_register_styles');

function improvedtheme_register_scripts(){
    $uri = get_template_directory_uri();
    wp_enqueue_script('gabsters-script', $uri . '/dist/script.js', array(), '', 'all');
}

add_action('wp_enqueue_scripts','improvedtheme_register_scripts');


function gabsters_enqueue_block_assets()
{
    wp_enqueue_style('gabsters-editor-styles', get_template_directory_uri() . '/dist/styles.css');
    wp_enqueue_script('gabsters-editor-script', get_stylesheet_directory_uri() . '/dist/script.js', array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'), false, true);
}

add_action('enqueue_block_assets', 'gabsters_enqueue_block_assets');

function only_logged_in_users_can_purchase($is_purchasable) {
    if (!is_user_logged_in()) {
        return false;
    }
    return $is_purchasable;
}

add_filter('woocommerce_is_purchasable', 'only_logged_in_users_can_purchase');

function customize_unavailable_product_message($availability, $product) {
    if (!$product->is_purchasable()) {
        $locale = get_locale();

        if ($locale === 'es_ES') {
            return 'Lo siento, debes iniciar sesión para agregar este producto al carrito.';
        } elseif ($locale === 'en_US') {
            return 'Sorry, you must log in to add this product to the cart.';
        } else {
            return 'Sorry, this product is unavailable.';
        }
    }
    return $availability;
}

add_filter('woocommerce_get_availability_text', 'customize_unavailable_product_message', 10, 2);
?>