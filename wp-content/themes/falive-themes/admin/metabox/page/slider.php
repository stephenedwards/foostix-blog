<?php

return array(
    'id'          => 'jeg_slider',
    'types'       => array('page'),
    'title'       => 'Featured Slider Options',
    'priority'    => 'high',
    'template'    => array(
        array(
            'type' => 'toggle',
            'name' => 'show_slider',
            'label' => 'Show Featured Slider',
            'description' => 'Display featured post slider on homepage',
            'default' => '1'
        ),

        array(
            'type' => 'select',
            'name' => 'slider_type',
            'label' =>  'Slider Type' ,
            'description' =>  'Select homepage slider type' ,
            'items' => array(
                array(
                    'value' => 'fullslider',
                    'label' =>  'Full Slider' ,
                ),
                array(
                    'value' => 'highlightslider',
                    'label' =>  'Highlight Slider' ,
                ),
                array(
                    'value' => 'stack',
                    'label' => 'Stack Slider' ,
                ),
            ),
            'dependency' => array(
                'field'    => 'show_slider',
                'function' => 'vp_dep_boolean',
            ),
        ),

        array(
            'type' => 'slider',
            'name' => 'slider_post_count',
            'label' => 'Slider Post Count',
            'description' => 'Set the slider post number',
            'min' => '1',
            'max' => '10',
            'step' => '1',
            'default' => '5',
            'dependency' => array(
                'field'    => 'slider_type',
                'function' => 'jeg_slider_not_stack',
            ),
        ),
        array(
            'type' => 'multiselect',
            'name' => 'slider_filter_categories',
            'label' => 'Select Post Category(s)',
            'description' => 'Include post in this category(s)',
            'items' => array(
                array('value' => '', 'label' => 'ALL'),
                'data' => array(
                    array(
                        'source' => 'function',
                        'value'  => 'vp_get_categories',
                    ),
                ),
            ),
            'dependency' => array(
                'field'    => 'show_slider',
                'function' => 'vp_dep_boolean',
            ),
        ),
        array(
            'type' => 'multiselect',
            'name' => 'slider_filter_tags',
            'label' => 'Select Post Tag(s)',
            'description' => 'Include post in this Tag(s)',
            'items' => array(
                array('value' => '', 'label' => 'ALL'),
                'data' => array(
                    array(
                        'source' => 'function',
                        'value'  => 'vp_get_tags',
                    ),
                ),
            ),
            'dependency' => array(
                'field'    => 'show_slider',
                'function' => 'vp_dep_boolean',
            ),
        ),

        // Fullslider
        array(
            'type'      => 'group',
            'repeating' => false,
            'length'    => 1,
            'name'      => 'jeg_slider_fullslider_options',
            'title'     => 'Advanced Slider Options',
            'dependency' => array(
                'field'    => 'slider_type',
                'function' => 'jeg_slider_fullslider',
            ),
            'fields'    => array(
                array(
                    'type' => 'radiobutton',
                    'name' => 'animation',
                    'label' => 'Slide Animation',
                    'items' => array(
                        array(
                            'value' => 'fade',
                            'label' => 'Fade',
                        ),
                        array(
                            'value' => 'slide',
                            'label' => 'Slide',
                        ),
                    ),
                    'default' => array('slide'),
                ),
                array(
                    'type' => 'toggle',
                    'name' => 'autoplay',
                    'label' =>  'Autoplay Slideshow',
                ),
                array(
                    'type' => 'slider',
                    'name' => 'delay',
                    'label' => 'Slideshow Speed',
                    'description' => 'Set the speed of the slideshow cycling, in seconds',
                    'min' => '1',
                    'max' => '10',
                    'step' => '1',
                    'default' => '7',
                ),
            )
        ),

        // Highlight Slider
        array(
            'type'      => 'group',
            'repeating' => false,
            'length'    => 1,
            'name'      => 'jeg_slider_highlightslider_options',
            'title'     => 'Advanced Slider Options',
            'dependency' => array(
                'field'    => 'slider_type',
                'function' => 'jeg_slider_highlightslider',
            ),
            'fields'    => array(
                array(
                    'type' => 'radiobutton',
                    'name' => 'animation',
                    'label' => 'Slide Animation',
                    'items' => array(
                        array(
                            'value' => 'fade',
                            'label' => 'Fade',
                        ),
                        array(
                            'value' => 'slide',
                            'label' => 'Slide',
                        ),
                    ),
                    'default' => array('slide'),
                ),
                array(
                    'type' => 'toggle',
                    'name' => 'autoplay',
                    'label' =>  'Autoplay Slideshow',
                ),
                array(
                    'type' => 'slider',
                    'name' => 'delay',
                    'label' => 'Slideshow Speed',
                    'description' => 'Set the speed of the slideshow cycling, in seconds',
                    'min' => '1',
                    'max' => '10',
                    'step' => '1',
                    'default' => '7',
                ),
            )
        ),
    ),
);