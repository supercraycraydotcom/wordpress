<?php
/**
 * Columns Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_dropcaps_shortcode') ) :
function warta_dropcaps_shortcode( $atts, $content = '' ) {
    $content    = wp_kses_post($content);
    
    return  strlen( $content ) == 1
            ? '<span class="dropcaps">' . $content . '</span>'
            : '<p class="dropcaps">' . $content . '</p>';
}
endif; // warta_dropcaps_shortcode
add_shortcode( 'dropcaps', 'warta_dropcaps_shortcode' );