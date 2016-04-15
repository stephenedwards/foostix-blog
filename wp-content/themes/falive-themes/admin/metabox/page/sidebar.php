<?php

return array(
    'id'          => 'jeg_sidebar',
    'types'       => array('page'),
    'title'       => 'Sidebar Options',
    'priority'    => 'high',
    'template'    => array(

        array(
            'type' => 'toggle',
            'name' => 'show_sidebar',
            'label' => 'Show Sidebar',
            'description' => 'Display sidebar that contains widgets',
            'default' => 1,
        ),

        array(
            'type' => 'select',
            'name' => 'sidebar_name',
            'label' => 'Sidebar Widget',
            'description' => 'Select widget for Sidebar',
            'default' => '{{first}}',
            'items' => array(
                'data' => array(
                    array(
                        'source' => 'function',
                        'value'  => 'jeg_plugin_get_sidebar',
                    ),
                ),
            ),
            'dependency' => array(
                'field'    => 'show_sidebar',
                'function' => 'vp_dep_boolean',
            ),
        ),

    ),
);