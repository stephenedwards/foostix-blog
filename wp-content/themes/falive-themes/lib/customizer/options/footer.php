<?php

global $wp_customize;

/*** Footer Options **/
new Jeg_Customizer_Framework(array(
    'name'          => 'jeg_option_footer',
    'title'         => 'Footer',
    'priority'      => 10,
    'description'   => ''
), array(

    array(
        'type'      => 'color',
        'name'      => 'footer_bg',
        'title'     => 'Footer Second Line Background',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'color',
        'name'      => 'footer_text_color',
        'title'     => 'Footer Text Color',
        'transport' => 'refresh',
        'default'   => null,
    ),

), $wp_customize);