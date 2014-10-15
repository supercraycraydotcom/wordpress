<?php

/* 
 * Post format image functions
 * 
 * @package Warta
 */

if( !function_exists('warta_match_image') ) :
function warta_match_image() {   
        $content    = apply_filters( 'the_content', get_the_content() );
        $output     = array();
                
        preg_match('/\<img.+?src=[\'\"](.+?)[\'\"].*?\>/i', $content, $matches_image);
        
        if( $matches_image ) {
            $output['image']        = $matches_image[0];
            $output['image_url']    = $matches_image[1];
        }               
        
        return $output;
}
endif; // warta_match_image 


