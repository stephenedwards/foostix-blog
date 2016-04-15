<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie10" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php echo bloginfo('rss2_url'); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="wrapper" class="<?php echo esc_attr(apply_filters('jeg_layout_container', vp_option('joption.page_layout', 'boxed'))); ?>">

<?php
    $header_layout = apply_filters('jeg_header_type', vp_option('joption.header_layout', '1'));
    get_template_part( 'include/header', 'layout'. $header_layout );
?>