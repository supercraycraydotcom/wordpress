<?php
/**
 * Tabs Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_tabs_shortcode') ) :
/**
 * Tabs container
 * =============================================================================
 */
function warta_tabs_shortcode( $atts, $content = '' ) {    
    return '<section class="widget">' . do_shortcode( $content ) . '</section>';
}
endif; // warta_columns_shortcode
add_shortcode( 'tabs', 'warta_tabs_shortcode' );



if( !function_exists('warta_tab_head_shortcode') ) :
/**
 * Tab head
 * =============================================================================
 */
function warta_tab_head_shortcode( $atts, $content = '' ) {    
    return '<ul class="nav nav-tabs">' . do_shortcode( $content ) . '</ul>';
}
endif; // warta_tab_head_shortcode
add_shortcode( 'tab_head', 'warta_tab_head_shortcode' );



if( !function_exists('warta_tab_body_shortcode') ) :
/**
 * Tab body
 * =============================================================================
 */
function warta_tab_body_shortcode( $atts, $content = '' ) {    
    return '<div class="tab-content">' . do_shortcode( $content ) . '</div>';
}
endif; // warta_tab_head_shortcode
add_shortcode( 'tab_body', 'warta_tab_body_shortcode' );




if( !function_exists('warta_tab_title_shortcode') ) :
/**
 * Tab Title
 * -----------------------------------------------------------------------------
 */
function warta_tab_title_shortcode( $atts, $content = '' ) { 
    extract( shortcode_atts( 
        array( 'active' => false ), 
        $atts 
    ) );
    
    $active = $active ? ' class="active"' : '';
    
    return '<li ' . $active . '><a href="#' . sanitize_html_class($content) . '" data-toggle="tab">' . strip_tags( $content ) . '</a></li>';
}
endif; // warta_tab_head_shortcode
add_shortcode( 'tab_title', 'warta_tab_title_shortcode' );




if( !function_exists('warta_tab_content_shortcode') ) :
/**
 * Tab Content
 * -----------------------------------------------------------------------------
 */
function warta_tab_content_shortcode( $atts, $content = '' ) { 
    extract( shortcode_atts( 
        array( 
            'active'    => false,
            'for'       => ''
        ), 
        $atts 
    ) );
    
    $active     = $active ? 'in active' : '';
    $content    = apply_filters('the_content', $content);
    $content    = str_replace(']]>', ']]&gt;', $content);
    
    return '<div class="tab-pane fade ' . $active . '" id="' . sanitize_html_class( $for ) . '">' . $content . '</div>';
}
endif; // warta_tab_head_shortcode
add_shortcode( 'tab_content', 'warta_tab_content_shortcode' );

