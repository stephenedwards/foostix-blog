<?php

return array(
    'id'          => 'jeg_blogcontent',
    'types'       => array('page'),
    'title'       => 'Blog Content Options',
    'priority'    => 'high',
    'template'    => array(

        array(
            'type' => 'radiobutton',
            'name' => 'layout',
            'label' => 'Content Layout',
            'description' => 'Select posts layout',
            'items' => array(
                array(
                    'value' => 'normal',
                    'label' => 'Normal',
                ),
                array(
                    'value' => 'masonry',
                    'label' => 'Masonry',
                ),
            ),
            'default' => array('normal')
        ),

        array(
            'type' => 'radiobutton',
            'name' => 'content_type',
            'label' =>  'Content Type' ,
            'description' =>  'Select type of content to display' ,
            'items' => array(
                array(
                    'value' => 'excerpt',
                    'label' =>  'Summary (excerpt)' ,
                ),
                array(
                    'value' => 'full',
                    'label' =>  'Full' ,
                ),
            ),
            'default' => array('excerpt'),
            'dependency' => array(
                'field'    => 'layout',
                'function' => 'jeg_content_normal',
            ),
        ),

        array(
            'type' => 'slider',
            'name' => 'post_limit',
            'label' => 'Limit Post',
            'description' => 'Set number of post to show per page',
            'min' => '1',
            'max' => '20',
            'step' => '1',
            'default' => '5',
        ),
        array(
            'type' => 'toggle',
            'name' => 'filter_post',
            'label' => 'Filter Post',
            'description' => 'Display specific posts',
        ),
        array(
            'type'      => 'group',
            'repeating' => false,
            'length'    => 1,
            'name'      => 'jeg_filter_post',
            'title'     => 'Filter Posts Options',
            'dependency' => array(
                'field'    => 'filter_post',
                'function' => 'vp_dep_boolean',
            ),
            'fields'    => array(
                array(
                    'type' => 'radiobutton',
                    'name' => 'filter_type',
                    'label' => 'Filter By',
                    'description' => 'Different type will show different type of field',
                    'items' => array(
                        array(
                            'value' => 'category',
                            'label' => 'Category',
                        ),
                        array(
                            'value' => 'tags',
                            'label' => 'Tags',
                        ),
                    ),
                ),
                array(
                    'type' => 'multiselect',
                    'name' => 'filter_category',
                    'label' => 'Filter Category(s)',
                    'description' => 'Include or exclude category',
                    'items' => array(
                        'data' => array(
                            array(
                                'source' => 'function',
                                'value'  => 'vp_get_categories',
                            ),
                        ),
                    ),
                    'dependency' => array(
                        'field'    => 'filter_type',
                        'function' => 'jeg_dep_is_category',
                    ),
                ),
                array(
                    'type' => 'multiselect',
                    'name' => 'filter_tags',
                    'label' => 'Filter Tag(s)',
                    'description' => 'Include or exclude tags',
                    'items' => array(
                        'data' => array(
                            array(
                                'source' => 'function',
                                'value'  => 'vp_get_tags',
                            ),
                        ),
                    ),
                    'dependency' => array(
                        'field'    => 'filter_type',
                        'function' => 'vp_dep_is_tags',
                    ),
                ),
                array(
                    'type' => 'radiobutton',
                    'name' => 'filter_rule',
                    'label' => 'Filter Rule',
                    'description' => 'filter content by this rule',
                    'default' => array('include'),
                    'items' => array(
                        array(
                            'value' => 'include',
                            'label' => 'Include',
                        ),
                        array(
                            'value' => 'exclude',
                            'label' => 'Exclude',
                        ),
                    ),
                ),

            )
        ),


    ),
);