<?php

$sections[]     = array(
        'title'     => __('Homepage', 'warta'),
        'icon'      => 'el-icon-home',
        'fields'    => array(
                array(
                        'id'    => 'deprecated_homepage',
                        'type'  => 'info',
                        'style' => 'critical',
                        'icon'  => 'el-icon-info-sign',
                        'title' => __('WARNING', 'warta'),
                        'desc'  => __('Settings in this section will be removed soon. Please use page builder instead', 'warta')
                ),
                array(
                        'id'       => 'homepage_layout',
                        'type'     => 'image_select',
                        'title'    => __('Hompage Layout', 'warta'), 
                        'subtitle' => __('Choose layout with full width carousel or small carousel.', 'warta'),
                        'options'  => array(
                                1   => array(
                                        'alt'   => 'Full Width Carousel', 
                                        'img'   => get_template_directory_uri() . '/deprecated/img/layout-home-v1.jpg'
                                ),
                                2   => array(
                                        'alt'   => 'Small Carousel', 
                                        'img'   => get_template_directory_uri() . '/deprecated/img/layout-home-v2.jpg'
                                )
                        ),
                        'default'   => 2,
                        'validate'  => 'numeric'
                ),
            array(
                'id'        =>'homepage_title_bg',
                'type'      => 'media', 
                'title'     => __('Title Background', 'warta'),
                'subtitle'  => __('Recommended size 1920x150px for full width layout and 1260x150px for boxed layout.', 'warta'),
                'compiler'  => true,
                'url'       => false, 
                'required'  => array( 'homepage_layout', '=', 2 )
            ),	

            array(
                'id'       => 'homepage_specific_widget',
                'type'     => 'checkbox',
                'title'    => __('Use Custom Widgets Area', 'warta'), 
                'subtitle' => __('Add new widgets area for Homepage to replace the default widgets area.', 'warta'),
                'options'  => array(
                    'sidebar'   => __('Sidebar Section', 'warta'),
                    'footer'    => __('Footer Section', 'warta'),
                ),
            ),

            array(
               'id'       => 'homepage_footer_layout',
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
        ),  
);