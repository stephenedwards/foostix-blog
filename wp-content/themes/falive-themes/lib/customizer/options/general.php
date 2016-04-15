<?php

global $wp_customize;

/*** General Settings **/
new Jeg_Customizer_Framework(
    array(
        'name'          => 'jeg_option_general',
        'title'         => 'General Options',
        'priority'      => 1,
        'description'   => ''
    ),
    array(

        array(
            'type'      => 'color',
            'name'      => 'text_color',
            'title'     => 'Base Text Color',
            'transport' => 'refresh',
            'default'   => null,
        ),
        array(
            'type'      => 'color',
            'name'      => 'link_color',
            'title'     => 'Link Color',
            'transport' => 'refresh',
            'default'   => null,
        ),
        array(
            'type'      => 'color',
            'name'      => 'link_hover_color',
            'title'     => 'Link Hover Color',
            'transport' => 'refresh',
            'default'   => null,
        ),
        array(
            'type'      => 'color',
            'name'      => 'button_color',
            'title'     => 'Accent Color',
            'transport' => 'refresh',
            'default'   => null,
        ),
), $wp_customize);