<?php
/**
 * Template Name: Login Page
 *
 * Standalone login page, without header.php/footer.php.
 * Styles: dist/styles.css, assets/css/login.css
 *
 * It does not call wp_head(), so it prints the theme.json fonts and global
 * styles itself, and it is excluded from search engines (noindex). The
 * form posts to wp-login.php with fetch, keeping the session cookies, and
 * reports the result with alerts; on success it follows the redirect.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_bloginfo('name') . ' - ' . __('Login', 'wordpress-classic-template'); ?></title>

    <meta name="robots" content="noindex, nofollow">

    <?php if (has_site_icon()) : ?>
        <link rel="icon" href="<?php echo esc_url(get_site_icon_url()); ?>" sizes="any">
    <?php endif; ?>

    <?php wordpress_classic_template_preload_assets(); ?>
    <?php wp_print_font_faces(); ?>
    <style id="global-styles"><?php echo wp_get_global_stylesheet(); ?></style>
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/dist/styles.css'); ?>">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/login.css'); ?>">
</head>
<body class="page-login-body">
    <section class="login-form-container">
        <div class="banner-wordpress-classic-template">
            <img src="<?php echo get_template_directory_uri()?>/assets/images/wordpress-classic-template-logo-wide.webp" alt="WordPress Classic Template Logo"/>
        </div>
        <form id="login-form" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(site_url('/')); ?>">
            <h1><?php _e('Log In to your account', 'wordpress-classic-template'); ?></h1>
            <div class="form-inputs">
                <div class="single-input">
                    <label for="user_login"><?php _e('Username or Email Address', 'wordpress-classic-template'); ?></label>
                    <input type="text" name="log" id="user_login" required>
                </div>
                <div class="single-input">
                    <label for="user_pass"><?php _e('Password', 'wordpress-classic-template'); ?></label>
                    <input type="password" name="pwd" id="user_pass" required>
                </div>
                <div class="lost-password">
                    <a href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost your password?', 'wordpress-classic-template'); ?></a>
                </div>
                <div class="remember-line">
                    <div class="single-input-checkbox">
                        <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                        <label for="rememberme"><?php _e('Remember Me', 'wordpress-classic-template'); ?></label>
                    </div>
                    <button class="action-button" type="submit">
                        <span><?php _e('Log In', 'wordpress-classic-template'); ?></span>
                        <?php echo wordpress_classic_template_icon('arrow-right'); ?>
                    </button>
                </div>
            </div>
        </form>
    </section>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(loginForm);
        const actionUrl = loginForm.getAttribute('action');

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            if (response.ok) {
                const responseText = await response.text();

                if (responseText.includes('dashboard') || response.url.includes('wp-admin') || !response.url.includes('wp-login')) {
                    alert('Logged in successfully.');
                    window.location.href = response.url;
                } else if (responseText.includes('incorrect') || responseText.includes('error')) {
                    alert('Incorrect credentials. Please try again.');
                } else {
                    alert('An unexpected error occurred.');
                }
            } else {
                alert('Request failed: ' + response.status);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Could not complete the login.');
        }
    });
});
</script>

</body>
</html>
