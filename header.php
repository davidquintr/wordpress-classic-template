<?php
/**
 * Site header: document head, background layers and the identity header.
 * Styles: styles/parts/header.css, styles/parts/background.css
 *
 * Data: ACF options page "Global" (avatar, identity, social_medias).
 * The header is large on the front page and compact everywhere else.
 * The avatar is served as AVIF/WebP crops at its displayed size (84px on
 * the front page, 48px elsewhere) plus 2x for retina screens.
 */

$is_home  = is_front_page();
$avatar   = wordpress_classic_template_field('avatar', 'option');
$identity = wordpress_classic_template_field('identity', 'option');
$socials  = wordpress_classic_template_field('social_medias', 'option');
$networks = wordpress_classic_template_social_networks();

$name = !empty($identity['name']) ? $identity['name'] : get_bloginfo('name');
$role = !empty($identity['role']) ? $identity['role'] : get_bloginfo('description');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#121B32">
    <meta name="color-scheme" content="dark">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header<?php echo $is_home ? ' site-header-home' : ''; ?>">
    <a class="site-header-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <?php if (!empty($avatar['ID'])) : ?>
            <div class="site-header-portrait">
                <?php
                $avatar_width = $is_home ? 84 : 48;
                echo wordpress_classic_template_picture($avatar['ID'], array(
                    'widths' => array($avatar_width, $avatar_width * 2),
                    'sizes'  => $avatar_width . 'px',
                    'width'  => $avatar_width,
                    'class'  => 'site-header-avatar',
                    'alt'    => $avatar['alt'] ? $avatar['alt'] : $name,
                    'eager'  => true,
                ));
                ?>
            </div>
        <?php endif; ?>

        <?php if ($is_home) : ?>
            <div class="site-header-identity" data-nosnippet>
                <span class="site-header-name"><?php echo esc_html($name); ?></span>
                <?php if ($role) : ?>
                    <span class="site-header-role"><?php echo esc_html($role); ?></span>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <span class="screen-reader-text"><?php echo esc_html($name); ?></span>
        <?php endif; ?>
    </a>

    <?php if (!empty($socials)) : ?>
        <ul class="site-header-social">
            <?php
            foreach ($socials as $social) :
                $media = isset($social['media']) ? $social['media'] : '';
                if (empty($social['url']) || !isset($networks[$media])) {
                    continue;
                }
                $network = $networks[$media];
                $href    = ($media === 'email' ? 'mailto:' : '') . $social['url'];
                ?>
                <li class="social-link">
                    <div class="tooltip" data-tip="<?php echo esc_attr($network['label']); ?>">
                        <a href="<?php echo esc_url($href); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($network['label']); ?>">
                            <?php echo wordpress_classic_template_icon($network['icon']); ?>
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</header>

<main class="site-main">
