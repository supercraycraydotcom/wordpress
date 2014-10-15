<?php
/**
 * Font Awesome Icons Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_icons_shortcode') ) :
function warta_icons_shortcode( $atts, $content = '' ) {    
    extract( shortcode_atts( 
        array( 
            'icon'  => '',
        ), 
        $atts 
    ) );
    
    if( $icon ) 
            return '<i class="fa ' . esc_attr( $icon ) . '"></i>';        
}
endif; // warta_icons_shortcode
add_shortcode( 'font_awesome', 'warta_icons_shortcode' );