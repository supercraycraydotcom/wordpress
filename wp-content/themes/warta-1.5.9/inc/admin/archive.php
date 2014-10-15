<?php
/**
 * Archive Page Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
    'icon'      => 'el-icon-folder-close',
    'title'     => __('Archive Page', 'warta'),
    'fields'    => array(
        array(
            'id'       => 'archive_layout',
            'type'     => 'image_select',
            'title'    => __('Archive Page Layout', 'warta'), 
            'options'  => array(
                1 => array(
                    'alt'   => 'Large Image', 
                    'img'   => get_template_directory_uri() . '/img/admin/layout-blog-v1.jpg'
                ),
                2 => array(
                    'alt'   => 'Small Image', 
                    'img'   => get_template_directory_uri() . '/img/admin/layout-blog-v2.jpg'
                )
            ),
            'default'           => 1,
            'validate_callback' => 'warta_validate_integer'
        ),
        array(
           'id'       => 'archive_title_bg',
           'type'     => 'media', 
           'url'      => true,
           'title'    => __('Title Background', 'warta'),
           'subtitle' => __('Recommended size 1920x150px for full width layout and 1260x150px for boxed layout', 'warta'),
           'url'      => false
       ),
        array(
            'id'       => 'archive_date_format',
            'type'     => 'text',
            'title'    => __('Date Format', 'warta'),
            'subtitle' => __('Click <a href="http://codex.wordpress.org/Formatting_Date_and_Time#Examples" target="_blank">here</a> to see some examples.', 'warta'),
            'validate' => 'no_html',
            'default'  => 'l, F j, Y g:i a'
        ),
        array(
            'id'       => 'archive_excerpt_length',
            'type'     => 'slider', 
            'title'    => __('Excerpt Length', 'warta'),
            'subtitle' => __('How many characters do you want to show?','warta'),
            'default'  => '320',
            'min'      => '1',
            'step'     => '1',
            'max'      => '1000',
            'validate_callback' => 'warta_validate_integer'
        ),
        array(
            'id'       => 'archive_post_meta',
            'type'     => 'checkbox',
            'title'    => __('Post Meta', 'warta'), 
            'options'  => array(
                'date'         => __('Date', 'warta'),
                'format'       => __('Post format', 'warta'),
                'category'     => __('First category', 'warta'),
                'categories'   => __('All categories', 'warta'),
                'tags'         => __('Tags', 'warta'),
                'author'       => __('Author', 'warta'),
                'comments'     => __('Comments', 'warta'),
                'views'        => __('Views', 'warta'),
                'review_score' => __('Review score', 'warta'),
            ),
            'default'   => array(
                'date'          => 1,
                'format'        => 0,
                'category'      => 0,
                'categories'    => 1,
                'tags'          => 1,
                'author'        => 1,
                'comments'      => 1,
                'views'         => 1,     
                'review_score'  => 0,
            ),
            'validate'  => 'no_html'
        ),
        array(
            'id'       => 'archive_icons',
            'type'     => 'checkbox',
            'title'    => __('Icons', 'warta'), 
            'options'  => array(
                'author'       => __('Author', 'warta'),
                'comments'     => __('Comments', 'warta'),
                'format'       => __('Post Format', 'warta'),
            ),
            'default'   => array(
                'author'    => 1,
                'comments'  => 1,
                'format'    => 1, 
            ),
            'validate'  => 'no_html'
        ),
 
        array(
            'id'       => 'archive_specific_widget',
            'type'     => 'checkbox',
            'title'    => __('Use Custom Widgets Area', 'warta'), 
            'subtitle' => __('Add new widgets area for Archive Page to replace the default widgets area.', 'warta'),
            'options'  => array(
                'sidebar'   => __('Sidebar Section', 'warta'),
                'footer'    => __('Footer Section', 'warta'),
            ),
        ),
        
        array(
           'id'       => 'archive_footer_layout',
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