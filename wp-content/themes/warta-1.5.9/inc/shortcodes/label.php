<?php
/**
 * Label Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_label_shortcode') ) :
function warta_label_shortcode( $atts, $content = '' ) {    
        if( !isset($atts['type']) && isset($atts['style']) ) {
                $atts['type'] = $atts['style'];
        }
        extract( shortcode_atts( 
                array( 'type' => 'default' ), 
                $atts 
        ) );

        return '<span class="label label-' . esc_attr($type) . '">' . wp_kses_post($content) . '</span>';
}
endif; // warta_label_shortcode
add_shortcode( 'label', 'warta_label_shortcode' );