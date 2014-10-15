<?php
/**
 * Excerpt functions
 * 
 * @package Warta
 */

if( !function_exists( 'warta_the_excerpt_max_charlength' ) ) :
/**
 * Limit the excerpt maximum number of characters
 * 
 * @param int $charlength maximum number characters of the excerpt
 * @param string $excerpt the excerpt
 * @return string The excerpt
 */
function warta_the_excerpt_max_charlength($charlength, $excerpt = '') {
        $excerpt    = $excerpt ? $excerpt : get_the_excerpt();
        $output     = '';     
        $charlength++;

        if ( strlen( $excerpt ) > $charlength ) {
                $subex = substr( $excerpt, 0, $charlength - 5 );
                $exwords = explode( ' ', $subex );
                $excut = - ( strlen( $exwords[ count( $exwords ) - 1 ] ) );
                if ( $excut < 0 ) {
                    $output .= substr( $subex, 0, $excut );
                } else {
                    $output .= $subex;
                }
                $output .= '&hellip;';
        } else {
                $output .= $excerpt;
        }

        return strip_tags( $output );
}
endif; // warta_the_excerpt_max_charlength