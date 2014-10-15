<?php
/**
 * General Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
        'icon'  => 'el-icon-cog',
        'title' => __('General Settings', 'warta'),
        'fields'=> array(                
                array(
                    'id'       => 'logo',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => __('Logo', 'warta'),
                    'subtitle' => __('Recommended image height is 30-40px.', 'warta'),
                    'url'      => false
                ),
                array(
                    'id'       => 'title_bg',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => __('Default Title Background', 'warta'),
                    'subtitle' => __('Recommended size 1920x150px for full width layout and 1260x150px for boxed layout.', 'warta'),
                    'url'      => false
                ),
                array(
                    'id'       => 'favicon',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => __('Favicon', 'warta'),
                    'url'      => false
                ),
                array(
                    'id'       => 'footer_layout',
                    'type'     => 'image_select',
                    'title'    => __('Footer Layout', 'warta'), 
                    'subtitle' => __('Choose between 4 or 6 columns layout.', 'warta'),
                    'options'  => array(
                        1      => array(
                            'alt'   => '4 Column', 
                            'img'   => get_template_directory_uri() . '/img/admin/layout-footer-v1.jpg'
                        ),
                        2      => array(
                            'alt'   => '6 Column', 
                            'img'   => get_template_directory_uri() . '/img/admin/layout-footer-v2.jpg'
                        )
                    ),
                    'default'  => '2',
                     'validate_callback' => 'warta_validate_integer'
                ),
                  array(
                            'id'         =>'footer_text',
                            'type'       => 'editor',
                            'title'      => __('Footer Text', 'warta'), 
                            'default'    => 'Copyright &copy; 2014 - <strong>WarTa</strong>',
                            'validate'   => 'html'
                 ),
        )
);