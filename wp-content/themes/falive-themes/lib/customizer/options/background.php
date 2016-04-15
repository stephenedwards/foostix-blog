<?php

global $wp_customize;

/*** Sidebar Options **/
new Jeg_Customizer_Framework(array(
    'name'          => 'jeg_option_background',
    'title'         => 'Website Background',
    'priority'      => 11,
    'description'   => ''
), array(

    array(
        'type'      => 'color',
        'name'      => 'website_color_background',
        'title'     => 'Background Color',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'newupload',
        'name'      => 'website_image_background',
        'title'     => 'Background Image',
        'transport' => 'refresh',
        'default'   => null,
    ),
    array(
        'type'      => 'select',
        'name'      => 'website_background_vertical_position',
        'title'     => 'Background Image: Vertical Position',
        'transport' => 'refresh',
        'default'   => 'center',
        'choices'   => array(
            'left'      => 'Left',
            'center'    => 'Center',
            'right'     => 'Right',
        )
    ),
    array(
        'type'      => 'select',
        'name'      => 'website_background_horizontal_position',
        'title'     => 'Background Image: Horizontal Position',
        'transport' => 'refresh',
        'default'   => 'center',
        'choices'   => array(
            'top'       => 'Top',
            'center'    => 'Center',
            'bottom'    => 'Bottom',
        )
    ),
    array(
        'type'      => 'select',
        'name'      => 'website_background_repeat',
        'title'     => 'Background Image: Repeat',
        'transport' => 'refresh',
        'default'   => 'repeat',
        'choices'   => array(
            'repeat-x'      => 'Repeat Horizontal',
            'repeat-y'      => 'Repeat Vertical',
            'repeat'        => 'Repeat Image',
            'no-repeat'     => 'No Repeat'
        )
    ),
    array(
        'type'      => 'checkbox',
        'name'      => 'website_background_fullscreen',
        'title'     => 'Enable fullscreen background',
        'transport' => 'refresh',
        'default'   => false
    )

), $wp_customize);