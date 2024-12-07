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

/*
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
*/

function filter_search_results($query) {
    if ($query->is_search && !is_admin() && $query->is_main_query()) {
        $query->set('post_type', 'product');
    }
}
add_action('pre_get_posts', 'filter_search_results');



// Redirección personalizada solo para la página de registro
function redirect_register_page() {
    // Detectar si el usuario intenta registrarse a través de `wp-login.php?action=register`
    if (isset($_GET['action']) && $_GET['action'] === 'register' && !is_user_logged_in()) {
        wp_redirect(site_url('/register'));
        exit;
    }
}
add_action('login_form_register', 'redirect_register_page');

// Manejo del registro personalizado
function handle_custom_registration() {
    if (isset($_POST['register'])) {
        $errors = [];
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $user_login = sanitize_user($_POST['user_login']);
        $user_email = sanitize_email($_POST['user_email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($first_name) || empty($last_name) || empty($user_login) || empty($user_email) || empty($password) || empty($confirm_password)) {
            $errors[] = __('All fields are required.', 'gabsters-domain');
        }
        if (!is_email($user_email)) {
            $errors[] = __('Invalid email address.', 'gabsters-domain');
        }
        if (username_exists($user_login)) {
            $errors[] = __('Username already exists.', 'gabsters-domain');
        }
        if (email_exists($user_email)) {
            $errors[] = __('Email is already registered.', 'gabsters-domain');
        }
        if ($password !== $confirm_password) {
            $errors[] = __('Passwords do not match.', 'gabsters-domain');
        }

        if (empty($errors)) {
            $user_id = wp_create_user($user_login, $password, $user_email);
            if (!is_wp_error($user_id)) {
                update_user_meta($user_id, 'first_name', $first_name);
                update_user_meta($user_id, 'last_name', $last_name);
                wp_redirect(site_url('/login?registered=1'));
                exit;
            } else {
                $errors[] = __('An error occurred while creating your account. Please try again.', 'gabsters-domain');
            }
        }

        global $registration_errors;
        $registration_errors = $errors;
    }
}
add_action('init', 'handle_custom_registration');

// Redirección personalizada después de iniciar sesión
function custom_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        } else {
            return site_url('/');
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);


?>