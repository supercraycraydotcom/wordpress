<?php
/**
 * Carousel Settings.
 *
 * @package Warta
 */

$the_query  = new WP_Query( array( 
                'meta_key'          => '_thumbnail_id',
                'post_type'         => 'post',
                'posts_per_page'    => 100,
                'post_status'       => 'publish'      
            ) );
$posts      = array();
if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $posts[ get_the_ID() ] = get_the_title();
        }
} 

// Restore original Post Data 
wp_reset_postdata();

$sections[] = array(
    'title'     => __('Carousel', 'warta'),
    'desc'      => __('Carousel setting for Homepage', 'warta'),
    'icon'      => 'el-icon-photo',
    'fields'    => array(
            array(
                        'id'    => 'deprecated_carousel',
                        'type'  => 'info',
                        'style' => 'critical',
                        'icon'  => 'el-icon-info-sign',
                        'title' => __('WARNING', 'warta'),
                        'desc'  => __('Settings in this section will be removed soon. Please use page builder instead', 'warta')
                ),
        array(
            'id'       => 'carousel',
            'type'     => 'switch', 
            'title'    => __('Display Carousel', 'warta'),
            'validate_callback' => 'warta_validate_integer',
            'default'  => true
        ),
        array(
            'id'       => 'carousel_data',
            'type'     => 'radio',
            'title'    => __('Data', 'warta'), 
            'options'  => array(
                'latest'    => 'Latest posts', 
                'cats'      => 'Categories',
                'tags'      => 'Tags',
                'posts'     => 'Selected posts'
            ),
            'default'  => 'latest',
            'validate' => 'no_html'
        ),
        array(
                'id'                => 'carousel_categories',
                'type'              => 'select',
                'data'              => 'categories',
                'multi'             => true,
                'title'             => __('Categories', 'warta'), 
                'validate_callback' => 'warta_validate_integer',
                'required'          => array( 'carousel_data', '=', 'cats' )
        ),
        array(
                'id'                => 'carousel_tags',
                'type'              => 'select',
                'data'              => 'tags',
                'multi'             => true,
                'title'             => __('Tags', 'warta'), 
                'validate_callback' => 'warta_validate_integer',
                'required'          => array( 'carousel_data', '=', 'tags' )
        ),
        array(
                'id'                => 'carousel_posts',
                'desc'              => __('Only last 100 posts that are displayed.', 'warta'),
                'type'              => 'select',
                'multi'             => true,
                'title'             => __('Posts', 'warta'), 
                'validate_callback' => 'warta_validate_integer',
                'options'           => $posts,
                'required'          => array( 'carousel_data', '=', 'posts' )
        ),
        array(
            'id'       => 'carousel_count',
            'type'     => 'spinner', 
            'title'    => __('Number of posts', 'warta'),
            'subtitle' => __('How many posts do you want to display?','warta'),
            'default'  => 4,
            'min'      => 1,
            'step'     => 1,
            'max'      => 10,
            'validate_callback' => 'warta_validate_integer',
        ),
        array(
            'id'       => 'carousel_excerpt_length',
            'type'     => 'slider', 
            'title'    => __('Excerpt Length', 'warta'),
            'subtitle' => __('How many characters do you want to show?','warta'),
            'default'  => 320,
            'min'      => 0,
            'step'     => 1,
            'max'      => 1000,
            'validate_callback' => 'warta_validate_integer',
        ),
        array(
            'id'      => 'carousel_interval',
            'type'    => 'slider', 
            'title'   => __('Interval', 'warta'),
            'subtitle'=> __('The amount of time to delay between automatically cycling an item (in seconds)', 'warta'),
            'default' => 8000,
            'min'     => 100,
            'step'    => 100,
            'max'     => 20000,
            'validate_callback' => 'warta_validate_integer',
        ),
        array(
            'id'       => 'carousel_animation',
            'type'     => 'radio',
            'title'    => __('Animation', 'warta'), 
            'subtitle' => __('Caption animation', 'warta'),
            'options'  => array(
                'slide'     => 'Slide',
                'fade'      => 'Fade',
                'bounce'    => 'Bounce'
            ),
            'default'  => 'slide',
            'validate' => 'no_html'
        ),
        array(
            'id'      => 'carousel_animation_speed',
            'type'    => 'slider', 
            'title'   => __('Animation Speed', 'warta'),
            'subtitle'=> __('The amount of time to animate the caption (in seconds)', 'warta'),
            'default' => 2000,
            'min'     => 100,
            'step'    => 100,
            'max'     => 10000,
            'validate_callback' => 'warta_validate_integer',
        ),
        array(
            'id'       => 'carousel_hide_mobile',
            'type'     => 'switch', 
            'title'    => __('Hide on Mobile Devices', 'warta'),
            'subtitle' => __('Recommended for better performance.', 'warta'),
            'default'  => 1,
        )
    )
);     