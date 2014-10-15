<?php
/**
 * Button Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_spoiler_shortcode') ) :
function warta_spoiler_shortcode( $atts, $content = '' ) {    
        extract( shortcode_atts( 
                array( 
                        'button'        => 'primary',
                        'show_text'     => __('Show', 'warta'),
                        'hide_text'     => __('Hide', 'warta'),
                        'type'          => 'block',
                        'button_type'   => ''
                ), 
                $atts 
        ) );

        $wrapper        = $type == 'block' ? 'div' : 'span'; 
        
        if($type == 'block') {
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);
        } else {
                $content = wp_kses_post($content);
        }
        
        return '<' . $wrapper . 
                        ' class="spoiler"' .
                        ' data-button-class="btn btn-xs btn-' . esc_attr($button) . '"' .
                        ' data-show-text="' . esc_attr($show_text) . '"' .
                        ' data-hide-text="' . esc_attr($hide_text) . '"' .
                        ' data-type="' . esc_attr($type) . '"' .
                        ' data-button-type="' . esc_attr($button_type) . '">' .
                        $content .
                '</' . $wrapper . '>';
}
endif; // warta_button_shortcode
add_shortcode( 'spoiler', 'warta_spoiler_shortcode' );