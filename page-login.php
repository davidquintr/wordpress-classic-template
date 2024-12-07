<?php
/**
 * Template Name: Login Page
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_bloginfo('name') . ' - ' . __('Login', 'gabsters-domain'); ?></title>
    <!-- Meta tag para evitar la indexación -->
    <meta name="robots" content="noindex, nofollow">

    <!-- Ícono dinámico -->
    <?php if (function_exists('has_site_icon') && has_site_icon()) : ?>
        <link rel="icon" href="<?php echo esc_url(get_site_icon_url()); ?>" sizes="any">
    <?php else : ?>
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/default-icon.png" sizes="any">
    <?php endif; ?>

    <!-- Fuentes personalizadas -->
    <style>
        @font-face {
            font-family: 'Century Gothic';
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/centurygothic.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Century Gothic';
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/centurygothic_bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        body {
            font-family: 'Century Gothic', Arial, sans-serif;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/basic.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/login.css" />
</head>
<body class="page-login-body">
    <section class="login-form-container">
        <div class="banner-gabsters">
            <img src="<?php echo get_template_directory_uri()?>/assets/images/gabsters-logo-wide.webp" alt="Gabsters Logo"/>
        </div>
        <form id="login-form" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(site_url('/')); ?>">
            <h1><?php _e('Log In to your account', 'gabsters-domain'); ?></h1>
            <div class="form-inputs">
                <div class="single-input">
                    <label for="user_login"><?php _e('Username or Email Address', 'gabsters-domain'); ?></label>
                    <input type="text" name="log" id="user_login" required>
                </div>
                <div class="single-input">
                    <label for="user_pass"><?php _e('Password', 'gabsters-domain'); ?></label>
                    <input type="password" name="pwd" id="user_pass" required>
                </div>
                <div class="lost-password">
                    <a href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost your password?', 'gabsters-domain'); ?></a>
                </div>
                <div class="remember-line">
                    <div class="single-input-checkbox">
                        <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                        <label for="rememberme"><?php _e('Remember Me', 'gabsters-domain'); ?></label>
                    </div>
                    <button class="action-button" type="submit">
                        <span><?php _e('Log In', 'gabsters-domain'); ?></span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            <div class="divider-line">
                <span></span>
                <p><?php _e('Log In With', 'gabsters-domain'); ?></p>
                <span></span>
            </div>
        </form>
    </section>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita el envío automático

        const formData = new FormData(loginForm);
        const actionUrl = loginForm.getAttribute('action');

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin' // Incluye cookies de sesión
            });

            if (response.ok) {
                // Verifica si el usuario fue redirigido correctamente
                const responseText = await response.text();

                console.log(responseText)

                if (responseText.includes('dashboard') || response.url.includes('wp-admin') || !response.url.includes('wp-login')) {
                    alert('Inicio de sesión exitoso');
                    window.location.href = response.url; // Redirige si es necesario
                } else if (responseText.includes('incorrect') || responseText.includes('error')) {
                    alert('Credenciales incorrectas. Por favor, intenta de nuevo.');
                } else {
                    alert('Ocurrió un error inesperado.');
                }
            } else {
                alert('Error en la solicitud: ' + response.status);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('No se pudo completar el inicio de sesión.');
        }
    });
});
</script>

</body>
</html>

