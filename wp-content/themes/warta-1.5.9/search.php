<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Warta
 */

$friskamax_warta_var['page'] = 'archive';

if( isset($friskamax_warta['archive_layout']) && $friskamax_warta['archive_layout'] == 2 ) {
        $friskamax_warta_var['html_id'] = 'blog-version-2';
        $content_width = 360;
} else {
        $friskamax_warta_var['html_id'] = 'blog-version-1';
        $content_width = 717;
}

get_header(); 

warta_page_title( get_search_query(), __( 'Search Results for:', 'warta'), 1 ); // print page title

get_template_part('content', 'archive');
