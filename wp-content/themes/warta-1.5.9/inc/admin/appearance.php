<?php
/**
 * General Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
        'icon'  => 'el-icon-screen',
        'title' => __('Appearance', 'warta'),
        'fields' => array(
                array(
                        'id'                    => 'boxed_style',
                        'type'                  => 'switch',
                        'title'                 => __('Boxed style', 'warta'),
                        'default'               => 0,
                        'validate_callback'     => 'warta_validate_integer'
                ),
                array(
                        'id'       => 'body_bg',
                        'type'     => 'media', 
                        'url'      => true,
                        'title'    => __('Body Background', 'warta'),
                        'subtitle' => __('Upload 1920x wide image.', 'warta'),
                        'url'      => false,
                        'required' => array('boxed_style','equals','1')
                ),
                array(
                        'id'                    => 'flat_style',
                        'type'                  => 'switch',
                        'title'                 => __('Flat style', 'warta'), 
                        'default'               => 0,
                        'validate_callback'     => 'warta_validate_integer'
                ),
                array(
                        'id'                    => 'image_light',
                        'type'                  => 'switch',
                        'title'                 => __('Light on images', 'warta'), 
                        'default'               => 1,
                        'validate_callback'     => 'warta_validate_integer'
                ),
                array(
                        'id'                    => 'zoom_effect',
                        'type'                  => 'switch',
                        'title'                 => __('Zoom effect', 'warta'), 
                        'default'               => 1,
                        'validate_callback'     => 'warta_validate_integer'
                ),
                 array(
                         'id'            => 'primary-color',
                         'type'          => 'color',
                         'title'         => __('Primary Color', 'warta'),
                         'default'       => '#fd4a29',
                         'validate'      => 'color',
                         'transparent'   => FALSE,
                         'compiler'      => true,
                 ),
                 array(
                         'id'            => 'secondary-color',
                         'type'          => 'color',
                         'title'         => __('Secondary Color', 'warta'),
                         'default'       => '#606068',
                         'validate'      => 'color',
                         'transparent'   => FALSE,
                         'compiler'      => true
                 ),
                 array(
                         'id'            => 'headings-link-color',
                         'type'          => 'color',
                         'title'         => __('Headings Link Color', 'warta'),
                         'default'       => '#606068',
                         'validate'      => 'color',
                         'transparent'   => FALSE,
                         'compiler'      => true,
                 ),
                 array(
                         'id'            => 'body-link-color',
                         'type'          => 'color',
                         'title'         => __('Body Link Color', 'warta'),
                         'default'       => '#3A74A6',
                         'validate'      => 'color',
                         'transparent'   => FALSE,
                         'compiler'      => true
                 )
        )                
);