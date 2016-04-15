<?php

function jeg_get_post_id()
{
    global $post;
    $p_post_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : null ;
    $g_post_id = isset($_GET['post']) ? $_GET['post'] : null ;
    $post_id = $g_post_id ? $g_post_id : $p_post_id ;
    $post_id = isset($post->ID) ? $post->ID : $post_id ;

    if (isset($post_id)) {
        return (integer) $post_id;
    }
    return null;
}

function jeg_get_current_page_template_name() {
    $post_id = jeg_get_post_id();
    return get_post_meta($post_id,'_wp_page_template',TRUE);
}