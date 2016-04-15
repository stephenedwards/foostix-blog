<?php

global $wp_customize;

/*** Header Layout 1 **/
new Jeg_Customizer_Framework(array(
    'name'          => 'jeg_option_header1',
    'title'         => 'Header - Layout 1',
    'priority'      => 3,
    'description'   => 'Customize color & style for Header Layout 1'
), array(

    array(
        'type'      => 'slider',
        'name'      => 'header1_logo_padding_top',
        'title'     => 'Logo Top Padding',
        'transport' => 'refresh',
        'default'   => 60,
        'min'       => 0,
        'max'       => 100,
        'step'      => 5
    ),
    array(
        'type'      => 'slider',
        'name'      => 'header1_logo_padding_bottom',
        'title'     => 'Logo Bottom Padding',
        'transport' => 'refresh',
        'default'   => 60,
        'min'       => 0,
        'max'       => 100,
        'step'      => 5
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_bg',
        'title'     => 'Header Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'color',
        'name'      => 'header1_menubar_bg',
        'title'     => 'Menubar Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'subtitle',
        'name'      => 'header1_menu_title',
        'title'     => 'Menu',
        'description' => 'Top menu color options.'
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_menu_color',
        'title'     => 'Menu Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_menu_hover_color',
        'title'     => 'Menu Hover Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_menu_hover_bg',
        'title'     => 'Menu Hover Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'subtitle',
        'name'      => 'header1_submenu_title',
        'title'     => 'Sub Menu',
        'description' => 'Sub menu color options.'
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_submenu_bg',
        'title'     => 'Sub Menu Background',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_submenu_line',
        'title'     => 'Sub Menu Line Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_submenu_color',
        'title'     => 'Sub Menu Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_submenu_hover_color',
        'title'     => 'Sub Menu Hover Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_submenu_hover_bg',
        'title'     => 'Sub Menu Hover Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'subtitle',
        'name'      => 'header1_search_title',
        'title'     => 'Search Form',
        'description' => 'Top search color options.'
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_search_color',
        'title'     => 'Search Icon Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_search_bg',
        'title'     => 'Search Icon Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'subtitle',
        'name'      => 'header1_social_title',
        'title'     => 'Social Icon',
        'description' => 'Top social icon color options.'
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_social_color',
        'title'     => 'Social Icon Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_social_hover_color',
        'title'     => 'Social Icon Hover Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header1_social_hover_bg',
        'title'     => 'Social Icon Hover Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

), $wp_customize);