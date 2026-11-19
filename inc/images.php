<?php
/**
 * Optimized images generated on demand.
 *
 * For a few key images (e.g. the header avatar) the theme creates square
 * crops at the exact sizes they are displayed, encoded as AVIF and WebP,
 * and serves them with <picture>. They are created on the first request
 * next to the original file (uploads/.../<name>-wct-<width>.<ext>), cached
 * in the attachment meta and removed when the attachment is deleted.
 * Unlike add_image_size(), nothing is generated for other uploads.
 *
 * - wordpress_classic_template_image_formats(): formats tried in order of
 *   preference with their encoding quality; formats the server can't
 *   encode are skipped.
 * - wordpress_classic_template_image_variant($id, $width, $mime): square
 *   crop of an attachment, returned as array('url', 'bytes'), or null if
 *   it can't be created. It never upscales, and the cache is tied to the
 *   source file, so replacing the image regenerates the crops.
 * - wordpress_classic_template_picture($id, $args): the <picture> markup.
 *   $args: widths (int[], include 2x for retina), sizes (e.g. '84px'),
 *   width (rendered width/height), class (for the <img>), alt, and eager
 *   (above the fold: eager loading with high priority).
 *   Sources are ordered lightest first, because the browser takes the
 *   first <source> it supports and, for small images, AVIF can be heavier
 *   than WebP: a format heavier than the previous one is dropped. The
 *   <img> fallback is the smallest registered size that covers the slot.
 * - wordpress_classic_template_delete_image_variants($id): removes the
 *   generated files of an attachment (hooked to delete_attachment).
 */

if (!defined('ABSPATH')) {
    exit;
}

const WORDPRESS_CLASSIC_TEMPLATE_IMAGE_META = '_wordpress_classic_template_optimized';

function wordpress_classic_template_image_formats() {
    return array(
        'image/avif' => array('ext' => 'avif', 'quality' => 60),
        'image/webp' => array('ext' => 'webp', 'quality' => 80),
    );
}

function wordpress_classic_template_image_variant($attachment_id, $width, $mime) {
    $formats = wordpress_classic_template_image_formats();
    $source  = get_attached_file($attachment_id);

    if (!isset($formats[$mime]) || !$source || !file_exists($source)) {
        return null;
    }

    $meta = get_post_meta($attachment_id, WORDPRESS_CLASSIC_TEMPLATE_IMAGE_META, true);
    $meta = is_array($meta) ? $meta : array();

    $source_key = basename($source) . ':' . filemtime($source);
    if (!isset($meta['source']) || $meta['source'] !== $source_key) {
        wordpress_classic_template_delete_image_variants($attachment_id);
        $meta = array('source' => $source_key, 'files' => array());
    }

    $key  = $mime . ':' . $width;
    $info = pathinfo($source);
    $path = $info['dirname'] . '/' . $info['filename'] . '-wct-' . $width . '.' . $formats[$mime]['ext'];

    if (!isset($meta['files'][$key]) || !file_exists($path)) {
        if (!wp_image_editor_supports(array('mime_type' => $mime))) {
            return null;
        }

        $editor = wp_get_image_editor($source);
        if (is_wp_error($editor)) {
            return null;
        }

        $size = $editor->get_size();
        if ($width > min($size['width'], $size['height'])) {
            return null;
        }

        $editor->set_quality($formats[$mime]['quality']);
        $editor->resize($width, $width, true);
        $saved = $editor->save($path, $mime);

        if (is_wp_error($saved)) {
            return null;
        }

        $meta['files'][$key] = basename($path);
        update_post_meta($attachment_id, WORDPRESS_CLASSIC_TEMPLATE_IMAGE_META, $meta);
    }

    return array(
        'url'   => dirname(wp_get_attachment_url($attachment_id)) . '/' . $meta['files'][$key],
        'bytes' => (int) filesize($path),
    );
}

function wordpress_classic_template_picture($attachment_id, $args) {
    $args = wp_parse_args($args, array(
        'widths' => array(),
        'sizes'  => '100vw',
        'width'  => 0,
        'class'  => '',
        'alt'    => '',
        'eager'  => false,
    ));

    if (!$attachment_id || !wp_attachment_is_image($attachment_id)) {
        return '';
    }

    $candidates = array();
    foreach (array_keys(wordpress_classic_template_image_formats()) as $mime) {
        $srcset = array();
        $bytes  = 0;
        foreach ($args['widths'] as $width) {
            $variant = wordpress_classic_template_image_variant($attachment_id, $width, $mime);
            if ($variant) {
                $srcset[] = esc_url($variant['url']) . ' ' . (int) $width . 'w';
                $bytes   += $variant['bytes'];
            }
        }
        if ($srcset) {
            $candidates[$mime] = array('srcset' => $srcset, 'bytes' => $bytes);
        }
    }

    $sources = '';
    $last    = null;
    foreach (array_reverse($candidates, true) as $mime => $candidate) {
        if ($last !== null && $candidate['bytes'] >= $last) {
            continue;
        }
        $last    = $candidate['bytes'];
        $sources = sprintf(
            '<source type="%s" srcset="%s" sizes="%s">',
            esc_attr($mime),
            implode(', ', $candidate['srcset']),
            esc_attr($args['sizes'])
        ) . $sources;
    }

    $fallback = wp_get_attachment_image_src($attachment_id, $args['width'] * 2 <= 150 ? 'thumbnail' : 'medium');
    if (!$fallback) {
        return '';
    }

    $img = sprintf(
        '<img src="%s" width="%d" height="%d" alt="%s" class="%s" decoding="async"%s>',
        esc_url($fallback[0]),
        (int) $args['width'],
        (int) $args['width'],
        esc_attr($args['alt']),
        esc_attr($args['class']),
        $args['eager'] ? ' loading="eager" fetchpriority="high"' : ' loading="lazy"'
    );

    return '<picture class="picture">' . $sources . $img . '</picture>';
}

function wordpress_classic_template_delete_image_variants($attachment_id) {
    $meta   = get_post_meta($attachment_id, WORDPRESS_CLASSIC_TEMPLATE_IMAGE_META, true);
    $source = get_attached_file($attachment_id);

    if (is_array($meta) && !empty($meta['files']) && $source) {
        $dir = dirname($source);
        foreach ($meta['files'] as $file) {
            wp_delete_file($dir . '/' . basename($file));
        }
    }
    delete_post_meta($attachment_id, WORDPRESS_CLASSIC_TEMPLATE_IMAGE_META);
}
add_action('delete_attachment', 'wordpress_classic_template_delete_image_variants');
