<?php
/**
 * Template Name: Blog
 *
 * @package Warta
 */ 
global  $friskamax_warta, 
        $friskamax_warta_var, 
        $content_width, 
        $wp_query;
    
$friskamax_warta_var['page'] = 'archive';    

if( isset($friskamax_warta['archive_layout']) && $friskamax_warta['archive_layout'] == 2 ) {
        $friskamax_warta_var['html_id'] = 'blog-version-2';
        $content_width = 360;
} else {
        $friskamax_warta_var['html_id'] = 'blog-version-1';
        $content_width = 717;
}

get_header();

if( is_front_page() ) {
        warta_page_title(get_bloginfo( 'name' ), get_bloginfo('description') );
} else {
        warta_page_title( get_the_title( get_queried_object_id() ), '' ); 
}

get_template_part('content', 'archive');