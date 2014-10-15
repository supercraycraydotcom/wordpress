<?php
/**
 * Columns Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_columns_shortcode') ) :
function warta_columns_shortcode( $atts, $content = '' ) {    
        extract( shortcode_atts( 
                array( 
                        'col'   => 1,
                        'align' => 'left'
                ), 
                $atts 
        ) );
        
        $align      = $align == 'full' || $align == 'justify' ? 'justify' : $align;
        $content    = wp_kses_post($content);

        return '<p class="col-' . (int) $col . '" style="text-align: ' . $align . '">' . do_shortcode($content) . '</p>';
}
endif; // warta_columns_shortcode
add_shortcode( 'columns', 'warta_columns_shortcode' );