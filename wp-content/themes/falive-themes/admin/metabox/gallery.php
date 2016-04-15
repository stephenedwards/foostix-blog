<?php

/**
 * Portfolio Gallery
*/

function jeg_gallery_metabox()
{
    return array(
        array(
            'id'            => 'jeg_gallery_meta',
            'type'          => 'mediagallery',
            'title'         => 'Gallery Builder',
            'description'   => 'Build Media Gallery Content ( you can use drag to change sequence )',
            'multi'         => true,
            'default'       => '',
            'option'            => array(
                'nowidth'       => false,
                'include'       => array('image'),
            )
        ),
    );
}

$portfoliometabox = new jeg_metabox_panel(array(
    'panelid'       => 'jeg_gallery_metabox',
    'screen'        => array('portfolio'),
    'pagetitle'     => 'Jkreativ Media Gallery Builder',
    'context'       => 'normal',
    'priority'      => 'high',
    'metacontent'   => 'jeg_gallery_metabox'
));