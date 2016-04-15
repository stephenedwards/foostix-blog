<?php

/*****
 * Page Metabox
 *****/
function jeg_pagemetabox_setup()
{
    new VP_Metabox(get_template_directory() . '/admin/metabox/page/slider.php');
    new VP_Metabox(get_template_directory() . '/admin/metabox/page/popularpost.php');
    new VP_Metabox(get_template_directory() . '/admin/metabox/page/blogcontent.php');
    new VP_Metabox(get_template_directory() . '/admin/metabox/page/sidebar.php');
    require_once(get_template_directory() . '/admin/metabox/gallery.php');
}
add_action('after_setup_theme', 'jeg_pagemetabox_setup');

function load_additional_script_for_page() {
    $screen = get_current_screen();
    if($screen->post_type === 'page' && is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jeg-page-metabox', get_template_directory_uri() . '/admin/assets/js/pagemetabox.js', null, null);

        $option = array();
        $option['pagetemplate'] = jeg_get_current_page_template_name();
        wp_localize_script('jeg-page-metabox', 'jpageoption', $option);

        wp_enqueue_style ('jeg-blog-css', get_template_directory_uri() . '/admin/assets/css/pagemetabox.css', null, null);
    }
}
add_action('current_screen', 'load_additional_script_for_page');

/** Load Metabox CSS **/
function load_additional_style() {
    if(is_admin()) {
        wp_enqueue_style ('jeg-global-css', get_template_directory_uri() . '/admin/assets/css/global.css', null, null);
    }
}
add_action('current_screen', 'load_additional_style');