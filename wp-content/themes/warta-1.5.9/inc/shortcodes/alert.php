<?php
/**
 * Alert Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_alert_shortcode') ) :
function warta_alert_shortcode( $atts, $content = '' ) { 
        if( !isset($atts['type']) && isset($atts['style']) ) {
                $atts['type'] = $atts['style'];
        }
        
        extract( shortcode_atts( 
                array( 'type' => 'default' ), 
                $atts 
        ) );
    
        return '<div class="alert alert-' . esc_attr($type) . '">' . wp_kses_post( $content ) . '</div>';
}
endif; // warta_alert_shortcode
add_shortcode( 'alert', 'warta_alert_shortcode' );