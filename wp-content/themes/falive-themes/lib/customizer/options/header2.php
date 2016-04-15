<?php

global $wp_customize;

/*** Header Layout 2 **/
new Jeg_Customizer_Framework(array(
    'name'          => 'jeg_option_header2',
    'title'         => 'Header - Layout 2',
    'priority'      => 4,
    'description'   => 'Customize color & style for Header Layout 2'
), array(

    array(
        'type'      => 'slider',
        'name'      => 'header2_height',
        'title'     => 'Header Height',
        'transport' => 'refresh',
        'default'   => 80,
        'min'       => 50,
        'max'       => 200,
        'step'      => 5
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_bg',
        'title'     => 'Header Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'subtitle',
        'name'      => 'header2_menu_title',
        'title'     => 'Menu',
        'description' => 'Top menu color options.'
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_menu_color',
        'title'     => 'Menu Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_menu_hover_color',
        'title'     => 'Menu Hover Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_menu_hover_bg',
        'title'     => 'Menu Hover Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'subtitle',
        'name'      => 'header2_submenu_title',
        'title'     => 'Sub Menu',
        'description' => 'Sub menu color options.'
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_submenu_bg',
        'title'     => 'Sub Menu Background',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_submenu_line',
        'title'     => 'Sub Menu Line Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_submenu_color',
        'title'     => 'Sub Menu Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_submenu_hover_color',
        'title'     => 'Sub Menu Hover Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_submenu_hover_bg',
        'title'     => 'Sub Menu Hover Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

    array(
        'type'      => 'subtitle',
        'name'      => 'header2_search_title',
        'title'     => 'Search Form',
        'description' => 'Top search color options.'
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_search_color',
        'title'     => 'Search Icon Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'header2_search_bg',
        'title'     => 'Search Icon Background',
        'transport' => 'refresh',
        'default'   => null,
    ),

), $wp_customize);