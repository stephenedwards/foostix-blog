<?php

global $wp_customize;

$webfonts    = jeg_get_googlefont();
$font_family = $webfonts['fonts_list'];
$font_weight = jeg_get_googlefont_weight( 'default', $webfonts );

/*** Typhography Settings **/
new Jeg_Customizer_Framework(
    array(
        'name'          => 'jeg_option_font',
        'title'         => 'Fonts',
        'priority'      => 2,
        'description'   => 'Font customizer is using Google Web Fonts.'
    ),
    array(

        // Global Font
        array(
            'type'      => 'subtitle',
            'name'      => 'font_body_subtitle',
            'title'     => 'Global Font',
            'description' => 'Base font for body, form, input, etc.'
        ),
        array(
            'type'      => 'select',
            'name'      => 'font_family_body',
            'title'     => 'Font Family',
            'transport' => 'refresh',
            'default'   => 'default',
            'choices'   => $font_family
        ),

        // Heading
        array(
            'type'      => 'subtitle',
            'name'      => 'font_heading_subtitle',
            'title'     => 'Heading',
            'description' => 'Essential heading font'
        ),
        array(
            'type'      => 'select',
            'name'      => 'font_family_heading',
            'title'     => 'Font Family',
            'transport' => 'refresh',
            'default'   => 'default',
            'choices'   => $font_family
        ),

        // Menu
        array(
            'type'      => 'subtitle',
            'name'      => 'font_menu_subtitle',
            'title'     => 'Menu',
            'description' => 'Font for side or top menu'
        ),
        array(
            'type'      => 'select',
            'name'      => 'font_family_menu',
            'title'     => 'Font Family',
            'transport' => 'refresh',
            'default'   => 'default',
            'choices'   => $font_family
        ),

), $wp_customize);