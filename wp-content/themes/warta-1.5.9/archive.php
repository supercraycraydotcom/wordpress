<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Warta
 */

$friskamax_warta_var['page'] = 'archive'; // page type. used for determining widgets area

if( isset($friskamax_warta['archive_layout']) && $friskamax_warta['archive_layout'] == 2 ) {
        $friskamax_warta_var['html_id'] = 'blog-version-2';
        $content_width = 360;
} else {
        $friskamax_warta_var['html_id'] = 'blog-version-1';
        $content_width = 717;
}

get_header();

$primary            = ''; // Title
$secondary          = ''; // Subtitle
$term_description   = term_description(); // Show an optional term description.

if ( is_category() ) :
        $primary    = single_cat_title('', 0);
        $secondary  = __('Category: ', 'warta');
elseif ( is_tag() ) :
        $primary    = single_tag_title('', 0);
        $secondary  = __('Tag: ', 'warta');
elseif ( is_author() ) :
        $secondary  = __( 'Author: ', 'warta' );
        $primary    = get_the_author();
elseif ( is_day() ) :
        $secondary  = __( 'Day: ', 'warta' );
        $primary    = get_the_date();
elseif ( is_month() ) :
        $secondary  = __( 'Month: ', 'warta' );
        $primary    = get_the_date( _x( 'F Y', 'monthly archives date format', 'warta' ) );
elseif ( is_year() ) :
        $secondary  = __( 'Year: ', 'warta' );
        $primary    = get_the_date( _x( 'Y', 'yearly archives date format', 'warta' ) );
elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
        $primary = __( 'Asides', 'warta' );
elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
        $primary = __( 'Galleries', 'warta');
elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
        $primary = __( 'Images', 'warta');
elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
        $primary = __( 'Videos', 'warta' );
elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
        $primary = __( 'Quotes', 'warta' );
elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
        $primary = __( 'Links', 'warta' );
elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
        $primary = __( 'Statuses', 'warta' );
elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
        $primary = __( 'Audios', 'warta' );
elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
        $primary = __( 'Chats', 'warta' );
else :
        $primary = __( 'Archives', 'warta' );
endif;

if( !!$term_description ) {
        $primary    = $secondary . $primary;
        $secondary  = strip_tags( $term_description );
}

/* warta_page_title( $primary, $secondary, $term_description ? 0 : 1 ); // print page title */

get_template_part('content', 'archive');