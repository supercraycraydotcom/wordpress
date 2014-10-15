<?php
/**
 * Singular Page Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
    'icon'      => 'el-icon-picture',
    'title'     => __('Gallery Page', 'warta'),
    'fields'    => array(
        array(
            'id'       => 'gallery_page_default',
            'type'     => 'switch', 
            'title'    => __('Use default WordPress style', 'warta'),
            'default'  => 0,
             'validate_callback' => 'warta_validate_integer'
        ),
        array(
            'id'      => 'gallery_page_caption_length',
            'type'    => 'slider', 
            'title'   => __('Caption Length', 'warta'),
            'subtitle'=> __('How many characters of the caption do you want to show?', 'warta'),
            'default' => '60',
            'min'     => '1',
            'step'    => '1',
            'max'     => '100',
            'validate'=> 'numeric',
            'required'  => array( 'gallery_page_default', '=', 0 )
        ),
    )
);