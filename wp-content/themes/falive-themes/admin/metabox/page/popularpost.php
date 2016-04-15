<?php

return array(
    'id'          => 'jeg_popularpost',
    'types'       => array('page'),
    'title'       => 'Popular Post Options',
    'priority'    => 'high',
    'template'    => array(

        // Popular Post
        array(
            'type' => 'toggle',
            'name' => 'show_popularpost',
            'label' => 'Show Popular Posts',
            'description' => 'Display popular posts carousel',
            'default' => 1,
        ),
        array(
            'type'      => 'group',
            'repeating' => false,
            'length'    => 1,
            'name'      => 'jeg_popularposts_options',
            'title'     => 'Popular Posts Options',
            'dependency' => array(
                'field'    => 'show_popularpost',
                'function' => 'vp_dep_boolean',
            ),
            'fields'    => array(
                array(
                    'type' => 'toggle',
                    'name' => 'autoplay',
                    'label' => 'Auto Slide',
                    'description' => 'Turn on auto slide carousel',
                ),
                array(
                    'type' => 'slider',
                    'name' => 'delay',
                    'label' => 'Slideshow Speed',
                    'description' => 'Set the speed of the slideshow cycling, in seconds',
                    'min' => '1',
                    'max' => '10',
                    'step' => '1',
                    'default' => '5',
                ),
                array(
                    'type' => 'slider',
                    'name' => 'count',
                    'label' => 'Popular Post Count',
                    'description' => 'Set number of post to show',
                    'min' => '1',
                    'max' => '15',
                    'step' => '1',
                    'default' => '5',
                ),
                array(
                    'type' => 'slider',
                    'name' => 'column',
                    'label' => 'Carousel Column',
                    'description' => 'Set column number of carousel post',
                    'min' => '3',
                    'max' => '5',
                    'step' => '1',
                    'default' => '4',
                ),

            )
        ),

    ),
);