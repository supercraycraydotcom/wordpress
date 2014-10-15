<?php
/**
 * Button Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_button_shortcode') ) :
function warta_button_shortcode( $atts, $content = '' ) {   
        if( !isset($atts['type']) && isset($atts['style']) ) {
                $atts['type'] = $atts['style'];
        }
        extract( shortcode_atts( 
                array( 
                        'type'  => 'default',
                        'size'  => '',
                        'url'   => '',
                        'target'=> ''
                ), 
                $atts 
        ) );
    
        $size   = $size ? ' btn-' . esc_attr( $size ) : '';
        $target = $target ? ' target="' . esc_attr( $target ) . '"' : '';

        return '<a href="' . esc_url( $url ) . '" class="btn btn-' . esc_attr($type) . $size . '"' . $target . '>' . strip_tags( $content ) . '</a>';
}
endif; // warta_button_shortcode
add_shortcode( 'button', 'warta_button_shortcode' );