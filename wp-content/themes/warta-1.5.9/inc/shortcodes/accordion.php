<?php
/**
 * Accordion Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_accordion_shortcode') ) :
/**
 * Accordion container
 * =============================================================================
 */
function warta_accordion_shortcode( $atts, $content = '' ) {    
    return '<div class="accordion">' . do_shortcode( $content ) . '</div>';
}
endif; // warta_accordion_shortcode
add_shortcode( 'accordion', 'warta_accordion_shortcode' );



if( !function_exists('warta_accordion_section_shortcode') ) :
/**
 * Accordion Section
 * =============================================================================
 */
function warta_accordion_section_shortcode( $atts, $content = '' ) {    
        extract( 
                shortcode_atts( 
                        array( 
                                'title'         => __('New Title', 'warta'),
                                'active'        => FALSE
                        ), 
                        $atts 
                ) 
        );

        $activeClass= !!$active ? ' active' : '';
        $content    = apply_filters('the_content', $content);
        $content    = str_replace(']]>', ']]&gt;', $content);

        return  '<div class="header' . $activeClass . '"><h5>' . strip_tags( $title ) . '</h5><i class="fa fa-plus"></i></div>'
                . '<div class="content">' . $content . '</div>';
}
endif; // warta_accordion_section_shortcode
add_shortcode( 'accordion_section', 'warta_accordion_section_shortcode' );


