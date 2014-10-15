<?php
/**
 * Singular Page Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
    'icon'      => 'el-icon-file',
    'title'     => __('Single Post Page', 'warta'),
    'fields'    => array(       
        array(
           'id'       => 'singular_title_bg',
           'type'     => 'media', 
           'url'      => true,
           'title'    => __('Title Background', 'warta'),
           'subtitle' => __('Recommended size 1920x150px for full width layout and 1260x150px for boxed layout.', 'warta'),
           'url'      => false
       ),
        array(
            'id'       => 'singular_date_format',
            'type'     => 'text',
            'title'    => __('Date Format', 'warta'),
            'subtitle' => __('Click <a href="http://codex.wordpress.org/Formatting_Date_and_Time#Examples" target="_blank">here</a> to see some examples.', 'warta'),
            'validate' => 'no_html',
            'default'  => 'l, F j, Y g:i a'
        ),
        array(
            'id'       => 'singular_post_meta',
            'type'     => 'checkbox',
            'title'    => __('Post Meta', 'warta'), 
            'options'  => array(
                'date'          => __('Date', 'warta'),
                'format'        => __('Post format', 'warta'),
                'categories'    => __('Categories', 'warta'),
                'author'        => __('Author', 'warta'),
                'comments'      => __('Comments', 'warta'),
                'views'         => __('Views', 'warta'),
                'tags'          => __('Tags', 'warta'),
                'review_score'  => __('Review score', 'warta'),
            ),
            'default'   => array(
                'date'      => 1,  
                'tags'      => 1,
                'views'     => 1,                      
            ),
            'validate'  => 'no_html'
        ),
        array(
            'id'       => 'singular_tag_text',
            'type'     => 'text',
            'title'    => __('Tag Text', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Tags:', 'warta')
        ),
        array(
            'id'       => 'singular_icons',
            'type'     => 'checkbox',
            'title'    => __('Icons', 'warta'), 
            'options'  => array(
                'author'        => __('Author', 'warta'),
                'comments'      => __('Comments', 'warta'),
                'format'        => __('Post Format', 'warta'),
            ),
            'default'   => array(
                'author'    => 1,
                'comments'  => 1,
                'format'    => 1,
            ),
            'validate'  => 'no_html'
        ),
        array(
            'id'                => 'singular_share_buttons_display',
            'type'              => 'switch', 
            'title'             => __('Display Share Buttons', 'warta'),
            'default'           => true,
            'validate_callback' => 'warta_validate_integer'
        ),
        array(
            'id'       => 'singular_share_text',
            'type'     => 'text',
            'title'    => __('Share Text', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Share:', 'warta'),
            'required'  => array( 'singular_share_buttons_display', '=', 1 )
        ),
        array(
            'id'       => 'singular_share_buttons',
            'type'     => 'checkbox',
            'title'    => __('Share Buttons', 'warta'), 
            'options'  => array(
                'facebook'          => $friskamax_warta_var['social_media_all']['facebook'],
                'googleplus'        => $friskamax_warta_var['social_media_all']['googleplus'],
                'linkedin'          => $friskamax_warta_var['social_media_all']['linkedin'],
                'pinterest'         => $friskamax_warta_var['social_media_all']['pinterest'],
                'stumbleupon'       => $friskamax_warta_var['social_media_all']['stumbleupon'],
                'twitter'           => $friskamax_warta_var['social_media_all']['twitter'],
                
                'digg'              => $friskamax_warta_var['social_media_all']['digg'],
                'mail'              => $friskamax_warta_var['social_media_all']['mail'],
                'tumblr'            => $friskamax_warta_var['social_media_all']['tumblr'],
            ),
            'default'   => array(
                'facebook'      => 1,
                'googleplus'    => 1,
                'linkedin'      => 1,
                'pinterest'     => 1,
                'stumbleupon'   => 1,
                'twitter'       => 1,
                
                'digg'          => 1,
                'mail'          => 1,
                'tumblr'        => 1,
            ),
            'validate'  => 'no_html',
            'required'  => array( 'singular_share_buttons_display', '=', 1 )
        ),
        array(
            'id'       => 'singular_author_info',
            'type'     => 'switch', 
            'title'    => __('Display Author Info', 'warta'),
            'default'  => true,
             'validate_callback' => 'warta_validate_integer'
        ),
        array(
            'id'       => 'singular_author_info_title',
            'type'     => 'text',
            'title'    => __('Author Info Title', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Author', 'warta'),
            'required'  => array( 'singular_author_info', '=', 1 )
        ),        
        array(
            'id'       => 'singular_related',
            'type'     => 'switch', 
            'title'    => __('Display Related Posts', 'warta'),
            'default'  => 1,
             'validate_callback' => 'warta_validate_integer'
        ),
        array(
            'id'       => 'singular_related_title',
            'type'     => 'text',
            'title'    => __('Related Posts Title', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Related Posts', 'warta'),
            'required'  => array( 'singular_related', '=', 1 )
        ),    
        array(
            'id'       => 'singular_related_post_meta',
            'type'     => 'checkbox',
            'title'    => __('Related Posts - Post Meta', 'warta'), 
            'options'  => array(
                'date'          => __('Date', 'warta'),
                'format'        => __('Post format', 'warta'),
                'category'      => __('Category', 'warta'),
                'author'        => __('Author', 'warta'),
                'comments'      => __('Comments', 'warta'),
                'views'         => __('Views', 'warta'),
            ),
            'default'   => array(
                'comments'  => 1,
                'date'      => 1,
                'views'     => 1,                      
            ),
            'validate'  => 'no_html',
            'required'  => array( 'singular_related', '=', 1 )
        ),        
        array(
            'id'       => 'singular_related_date_format',
            'type'     => 'text',
            'title'    => __('Related Posts - Date Format', 'warta'),
            'subtitle' => __('Click <a href="http://codex.wordpress.org/Formatting_Date_and_Time#Examples" target="_blank">here</a> to see some examples.', 'warta'),
            'validate' => 'no_html',
            'default'  => 'M j, Y',
            'required'  => array( 'singular_related', '=', 1 )
        ),

        array(
            'id'       => 'singular_specific_widget',
            'type'     => 'checkbox',
            'title'    => __('Use Custom Widgets Area', 'warta'), 
            'subtitle' => __('Add new widgets area for Single Post Page to replace the default widgets area.', 'warta'),
            'options'  => array(
                'sidebar'   => __('Sidebar Section', 'warta'),
                'footer'    => __('Footer Section', 'warta'),
            ),
        ),
        
        array(
           'id'       => 'singular_footer_layout',
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