<?php
/**
 * Adds blockquote html tag 
 * 
 * @package Warta
 */

if( !function_exists('warta_quote_content') ) :
/**
 * Adds blockquote html tag if there isn't any
 * 
 * @param string $content Post content
 * @return string Filtered post content
 */
function warta_quote_content( $content ) {
    preg_match( '/\[blockquote.*?\]/is', $content, $matches_blockquote_shortcode );

    /* Check if we're displaying a 'quote' post. */
    if ( has_post_format( 'quote' ) && !$matches_blockquote_shortcode ) {       
        
        preg_match( '/<blockquote.*?>/is', $content, $matches_blockquote );
        preg_match( '/<a.*?>/is', $content, $matches_a );
        preg_match( '/<cite.*?>/is', $content, $matches_cite);
        preg_match( '/<footer.*?>/is', $content, $matches_footer );
            
        if ( !$matches_blockquote && $matches_a ) {

            $content    = preg_replace(
                            '/(.*?)(<a.+?<\/a>)/is', 
                            '<blockquote>${1}<footer><cite>${2}</cite></footer></blockquote>', 
                            $content
                        );

        } else if( !$matches_blockquote ) { 

            $content = "<blockquote>{$content}</blockquote>";

        } else if( $matches_cite && !$matches_footer ) {

            $content    = preg_replace(
                            '/(<blockquote.*?>.*?)(<cite>.*?<\/cite>)(.*?<\/blockquote>)/is', 
                            '${1}<footer>${2}</footer>${3}', 
                            $content
                        );

        }
        
    }
        
    return $content;
}
endif; // warta_quote_content
add_filter( 'the_content', 'warta_quote_content', 1 );