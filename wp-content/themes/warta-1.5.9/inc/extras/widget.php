<?php
/**
 * Widget functions
 * 
 * @package Warta
 */

if( !function_exists( 'warta_is_sidebar' ) ) :
/**
 * Check whether the current widget location is in sidebar or not.
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @param string $id Sidebar ID
 * @return boolean
 */
function warta_is_sidebar($id) {
    return ( 
        $id === 'home-sidebar-section' || 
        $id === 'archive-sidebar-section' || 
        $id === 'singular-sidebar-section' || 
        $id === 'page-sidebar-section' || 
        $id === 'default-sidebar-section' 
    ) ? TRUE : FALSE;
}
endif;



if( !function_exists( 'warta_is_footer' ) ) :
/**
 * Check whether the current widget location is in footer or not.
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @param string $id Sidebar ID
 * @return boolean
 */
function warta_is_footer($id) {
    return ( 
        $id === 'home-footer-section' || 
        $id === 'archive-footer-section' || 
        $id === 'singular-footer-section' || 
        $id === 'page-footer-section' || 
        $id === 'default-footer-section' 
    ) ? TRUE : FALSE;
}
endif;



if( !function_exists( 'warta_is_main' ) ) :
/**
 * Check whether the current widget location is in #main-content or not.
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @param string $id Sidebar ID
 * @return boolean
 */
function warta_is_main($id) {
    return ( 
        $id === 'home-main-section' ||
        $id === 'archive-before-content-section' ||
        $id === 'archive-after-content-section' ||
        $id === 'singular-before-content-section' ||
        $id === 'singular-after-content-section'
    ) ? TRUE : FALSE;
}
endif;



if( !function_exists( 'warta_is_full' ) ) :
/**
 * Check whether the current widget location is in top and bottom section or not.
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @param string $id Sidebar ID
 * @return boolean
 */
function warta_is_full($id) {
    return ( 
        $id === 'home-top-section' || 
        $id === 'home-bottom-section' 
    ) ? TRUE : FALSE;
}
endif;



if( !function_exists( 'warta_add_clearfix' ) ) :
/**
 * Add clearfix in every row
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @global array $friskamax_warta_var Warta Theme Variables
 * @param int $sidebar_id Sidebar ID
 * @param int $col Current widget column
 */
function warta_add_clearfix( $sidebar_id, $col = 0 ) {
    global $friskamax_warta_var;
    
    if( !isset( $friskamax_warta_var['sidebar_counter'] ) )
            $friskamax_warta_var['sidebar_counter'] = 0;
    
    $friskamax_warta_var['sidebar_counter'] += warta_is_main( $sidebar_id ) || warta_is_full( $sidebar_id ) ? $col : 0;
    
    if ( 
        ( warta_is_main( $sidebar_id ) && $friskamax_warta_var['sidebar_counter'] % 12 === 0 ) ||
        ( warta_is_full( $sidebar_id ) && $friskamax_warta_var['sidebar_counter'] % 18 === 0 ) 
    ) : ?>

        <div class="clearfix"></div>
        
    <?php endif;
}
endif;



if( !function_exists( 'warta_widget_class' ) ) :
/**
 * 
 * @global array $friskamax_warta       Warta theme options
 * @global array $friskamax_warta_var   Warta theme variables
 * @param int $sidebar_id               Current sidebar ID
 * @param int $col                      Current widget columns
 * @param boolean $echo                 Is echo the output?
 * @param boolean $is_pb                Is using page builder?
 * @return string
 */
function warta_widget_class( $sidebar_id, $col = 6, $echo = TRUE, $is_pb = FALSE ) {    
        global  $friskamax_warta, 
                $friskamax_warta_var;

        if( $is_pb ) {
                $output = 'widget';
        } else if( warta_is_sidebar( $sidebar_id ) ) {     
                $output = 'widget col-sm-6 col-md-12';
        } else if( warta_is_footer( $sidebar_id ) ) {  
                if(     $friskamax_warta_var['page'] == 'home' && 
                        isset( $friskamax_warta['homepage_specific_widget']['footer'] ) && 
                        !!$friskamax_warta['homepage_specific_widget']['footer'] 
                ) {
                        $output = $friskamax_warta['homepage_footer_layout'] == 1 
                                ? 'widget col-md-2 col-sm-4' 
                                : 'widget col-md-3 col-sm-6';

                } else if( 
                        $friskamax_warta_var['page'] == 'archive' && 
                        isset( $friskamax_warta['archive_specific_widget']['footer'] ) && 
                        !!$friskamax_warta['archive_specific_widget']['footer'] 
                ) {
                        $output = $friskamax_warta['archive_footer_layout'] == 1 
                                ? 'widget col-md-2 col-sm-4' 
                                : 'widget col-md-3 col-sm-6';

                } else if( 
                        $friskamax_warta_var['page'] == 'singular' && 
                        isset( $friskamax_warta['singular_specific_widget']['footer'] ) && 
                        !!$friskamax_warta['singular_specific_widget']['footer'] ) 
                {
                        $output = $friskamax_warta['singular_footer_layout'] == 1 
                                ? 'widget col-md-2 col-sm-4' 
                                : 'widget col-md-3 col-sm-6';

                } else if( 
                        $friskamax_warta_var['page'] == 'page' && 
                        isset( $friskamax_warta['page_specific_widget']['footer'] ) && 
                        !!$friskamax_warta['page_specific_widget']['footer'] 
                ) {
                        $output = $friskamax_warta['page_footer_layout'] == 1 
                                ? 'widget col-md-2 col-sm-4' 
                                : 'widget col-md-3 col-sm-6';

                } else {
                        $output = $friskamax_warta['footer_layout'] == 1 
                                ? 'widget col-md-2 col-sm-4' 
                                : 'widget col-md-3 col-sm-6';
                }
        } else if( warta_is_full( $sidebar_id ) ) {
                $output = 'widget col-md-4';
        } else {
                $output = 'widget col-sm-' . $col;
        }

        if( $echo ) { 
                echo $output;
        } else {
                return $output;
        }
}
endif;