<?php
/**
 * Reusable template helpers (components rendered from PHP).
 *
 * - wordpress_classic_template_icon($name, $class): inline SVG icon from
 *   assets/icons (Tabler Icons, outline set, MIT). To add one, copy it from
 *   @tabler/icons (icons/outline/<name>.svg) into assets/icons/ without
 *   width/height/class attributes.
 *   Usage: echo wordpress_classic_template_icon('search');
 * - wordpress_classic_template_field($name, $post_id): ACF value with a
 *   safe fallback when ACF is not active.
 * - wordpress_classic_template_button($args): button component
 *   (styles/components/button.css). $args: href, content (inner HTML:
 *   icon and/or escaped label), size ('small' | 'medium'), fly (lift and
 *   tilt on hover), active (current page, rendered as a non-clickable
 *   span), label (aria-label), target, download, class.
 * - wordpress_classic_template_social_networks(): ACF "media" value =>
 *   label and Tabler icon. The ACF field currently offers facebook,
 *   linkedin, x, instagram and tiktok; the rest are ready in case those
 *   choices are added.
 * - wordpress_classic_template_is_file_url($url): whether a URL is a media
 *   library file or a downloadable document; used to show the download
 *   button next to a link.
 * - wordpress_classic_template_link($link): ACF link array (url, title,
 *   target) rendered as an optional download button plus a label button,
 *   mirroring the "link or file" component of the original site.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wordpress_classic_template_icon($name, $class = '') {
    static $cache = array();

    if (!isset($cache[$name])) {
        $file = get_template_directory() . '/assets/icons/' . sanitize_file_name($name) . '.svg';
        $cache[$name] = file_exists($file) ? trim(file_get_contents($file)) : '';
    }
    if ($cache[$name] === '') {
        return '';
    }

    $classes = trim('icon icon-' . $name . ' ' . $class);
    $attributes = sprintf(' class="%s" aria-hidden="true" focusable="false"', esc_attr($classes));

    return preg_replace('/^<svg/', '<svg' . $attributes, $cache[$name], 1);
}

function wordpress_classic_template_field($name, $post_id = false) {
    return function_exists('get_field') ? get_field($name, $post_id) : null;
}

function wordpress_classic_template_button($args) {
    $args = wp_parse_args($args, array(
        'href'     => '',
        'content'  => '',
        'size'     => 'small',
        'fly'      => true,
        'active'   => false,
        'label'    => '',
        'target'   => '',
        'download' => false,
        'class'    => '',
    ));

    $classes = array('button', 'button-' . $args['size']);
    if ($args['fly']) {
        $classes[] = 'button-fly';
    }
    if ($args['class']) {
        $classes[] = $args['class'];
    }

    if ($args['active']) {
        $classes[] = 'is-active';
        $sr_label = $args['label'] ? '<span class="screen-reader-text">' . esc_html($args['label']) . '</span>' : '';

        return sprintf(
            '<span aria-current="page" class="%1$s">%2$s<span class="button-inner"%3$s>%4$s</span></span>',
            esc_attr(implode(' ', $classes)),
            $sr_label,
            $args['label'] ? ' aria-hidden="true"' : '',
            $args['content']
        );
    }

    $attributes = sprintf(' href="%s"', esc_url($args['href']));
    if ($args['target']) {
        $attributes .= sprintf(' target="%s"', esc_attr($args['target']));
        if ($args['target'] === '_blank') {
            $attributes .= ' rel="noopener noreferrer"';
        }
    }
    if ($args['label']) {
        $attributes .= sprintf(' aria-label="%s"', esc_attr($args['label']));
    }
    if ($args['download']) {
        $attributes .= ' download';
    }

    return sprintf(
        '<a class="%1$s"%2$s><span class="button-inner">%3$s</span></a>',
        esc_attr(implode(' ', $classes)),
        $attributes,
        $args['content']
    );
}

function wordpress_classic_template_social_networks() {
    return array(
        'facebook'  => array('label' => 'Facebook', 'icon' => 'brand-facebook'),
        'linkedin'  => array('label' => 'LinkedIn', 'icon' => 'brand-linkedin'),
        'x'         => array('label' => 'X', 'icon' => 'brand-x'),
        'instagram' => array('label' => 'Instagram', 'icon' => 'brand-instagram'),
        'tiktok'    => array('label' => 'TikTok', 'icon' => 'brand-tiktok'),
        'github'    => array('label' => 'GitHub', 'icon' => 'brand-github'),
        'email'     => array('label' => 'Email', 'icon' => 'mail'),
        'whatsapp'  => array('label' => 'WhatsApp', 'icon' => 'brand-whatsapp'),
        'youtube'   => array('label' => 'YouTube', 'icon' => 'brand-youtube'),
        'threads'   => array('label' => 'Threads', 'icon' => 'brand-threads'),
    );
}

function wordpress_classic_template_is_file_url($url) {
    if (!$url) {
        return false;
    }
    if (attachment_url_to_postid($url)) {
        return true;
    }
    $path = wp_parse_url($url, PHP_URL_PATH);
    return (bool) preg_match('/\.(pdf|docx?|xlsx?|pptx?|zip|rar|7z)$/i', (string) $path);
}

function wordpress_classic_template_link($link) {
    if (empty($link['url'])) {
        return '';
    }

    $url    = $link['url'];
    $title  = !empty($link['title']) ? $link['title'] : $url;
    $target = !empty($link['target']) ? $link['target'] : '';
    $html   = '';

    if (wordpress_classic_template_is_file_url($url)) {
        $html .= wordpress_classic_template_button(array(
            'href'     => $url,
            'content'  => wordpress_classic_template_icon('download'),
            'label'    => sprintf(__('Download %s', 'wordpress-classic-template'), $title),
            'download' => true,
            'target'   => $target,
        ));
    }

    $icon = $target === '_blank' ? wordpress_classic_template_icon('external-link') : '';
    $html .= wordpress_classic_template_button(array(
        'href'    => $url,
        'content' => $icon . esc_html($title),
        'target'  => $target,
    ));

    return '<div class="link-group">' . $html . '</div>';
}
