<?php
/**
 * Walker for the bottom navigation (footer.php).
 *
 * Outputs each menu item as a button component, with no <ul>/<li>.
 * The navigation is flat: sub-items are not shown.
 * Icons: add a class "icon-<tabler-name>" to the menu item (Appearance >
 * Menus > Screen Options > CSS Classes), e.g. "icon-home". The icon file
 * must exist in assets/icons/.
 */

if (!defined('ABSPATH')) {
    exit;
}

class Wordpress_Classic_Template_Navigation_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {}

    public function end_lvl(&$output, $depth = 0, $args = null) {}

    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0) {
        if ($depth > 0) {
            return;
        }

        $item    = $data_object;
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $icon = '';
        foreach ($classes as $class) {
            if (strpos($class, 'icon-') === 0) {
                $icon = wordpress_classic_template_icon(substr($class, 5));
                break;
            }
        }

        $is_current = (bool) array_intersect($classes, array('current-menu-item', 'current_page_item'));
        $title      = apply_filters('the_title', $item->title, $item->ID);

        $output .= wordpress_classic_template_button(array(
            'href'    => $item->url,
            'size'    => 'medium',
            'active'  => $is_current,
            'target'  => $item->target ? $item->target : '_self',
            'label'   => sprintf(__('Navigate to %s', 'wordpress-classic-template'), wp_strip_all_tags($title)),
            'content' => $icon . '<span class="button-label">' . esc_html($title) . '</span>',
        ));
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null) {}
}
