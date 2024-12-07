<?php
/**
 * Template Name: Register Page
 */

get_header();
?>

<div class="register-form-container">
    <h1><?php _e('Register', 'gabsters-domain'); ?></h1>
    <form method="post" action="">
        <?php if (!empty($_POST) && isset($registration_errors)): ?>
            <div class="registration-errors">
                <?php foreach ($registration_errors as $error): ?>
                    <p style="color: red;"><?php echo esc_html($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p>
            <label for="first_name"><?php _e('First Name', 'gabsters-domain'); ?></label>
            <input type="text" name="first_name" id="first_name" required>
        </p>
        <p>
            <label for="last_name"><?php _e('Last Name', 'gabsters-domain'); ?></label>
            <input type="text" name="last_name" id="last_name" required>
        </p>
        <p>
            <label for="user_login"><?php _e('Username', 'gabsters-domain'); ?></label>
            <input type="text" name="user_login" id="user_login" required>
        </p>
        <p>
            <label for="user_email"><?php _e('Email Address', 'gabsters-domain'); ?></label>
            <input type="email" name="user_email" id="user_email" required>
        </p>
        <p>
            <label for="password"><?php _e('Password', 'gabsters-domain'); ?></label>
            <input type="password" name="password" id="password" required>
        </p>
        <p>
            <label for="confirm_password"><?php _e('Confirm Password', 'gabsters-domain'); ?></label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </p>
        <p>
            <button type="submit" name="register"><?php _e('Register', 'gabsters-domain'); ?></button>
        </p>
    </form>
</div>

<?php
get_footer();
?>
