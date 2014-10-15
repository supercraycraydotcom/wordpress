<?php
/**
 * Returns links on article medium's image hover
 * 
 * @package warta
 */

if ( ! function_exists( 'warta_image_links' ) ) :
/**
 * Returns links on article medium's image hover.
 */
function warta_image_links($link = '', $link_only = FALSE) {
    $attachment_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'huge');
    $link           = $link ? $link : $attachment_src[0];
    
    $output = '<div class="container-link">'
                . '<div class="link">'
                    . '<a href="' . esc_url( get_permalink() ) . '"><i class="fa fa-link fa-flip-horizontal"></i></a>';
    if( !$link_only ) {
        $output     .= ' <a href="' . esc_url($link)  . '" title="' . get_the_title() . '"><i class="fa fa-search-plus"></i></a>';
    }
    $output     .= '</div>'
            . '</div>';
    
    return $output;
}
endif;