<?php
/**
 * Singular Page Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
    'icon'      => 'el-icon-file',
    'title'     => __('Static Page', 'warta'),
    'fields'    => array(       
        array(
           'id'       => 'page_title_bg',
           'type'     => 'media', 
           'url'      => true,
           'title'    => __('Title Background', 'warta'),
           'subtitle' => __('Recommended size 1920x150px for full width layout and 1260x150px for boxed layout.', 'warta'),
           'url'      => false
       ),

        array(
            'id'       => 'page_specific_widget',
            'type'     => 'checkbox',
            'title'    => __('Use Custom Widgets', 'warta'), 
            'subtitle' => __('Add new widgets area for Static Page to replace the default widgets area.', 'warta'),
            'options'  => array(
                'sidebar'   => __('Sidebar Section', 'warta'),
                'footer'    => __('Footer Section', 'warta'),
            ),
        ),
        
        array(
           'id'       => 'page_footer_layout',
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
    )
);