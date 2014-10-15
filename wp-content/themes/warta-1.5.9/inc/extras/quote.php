<?php

/**
 * Post format quote functions
 * 
 * @package Warta
 */

if( !function_exists('warta_match_quote') ) :
/**
 * Get blockquote from a post
 * 
 * @return $string Blockquote html code
 */
function warta_match_quote() {
    
        $content    = apply_filters( 'the_content', get_the_content() );
        $output     = array();

        preg_match('/<blockquote.*?<\/blockquote>/is', $content, $matches_blockquote);
                
        if( $matches_blockquote ) {
                $output = $matches_blockquote[0];
        } 
                
        return $output;
    
} 
endif; // warta_match_quote
