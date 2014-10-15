<?php

if( !function_exists( 'warta_match_video' ) ) :
/**
 * Get video content from a post
 * =============================================================================
 * @return string Video html code
 */
function warta_match_video( $start = '', &$rest_content = '' ) {
    
        $content    = get_the_content();
        $output     = '';
        
        preg_match( "/{$start}(?:<p.*?>|)(\[video.*?\[\/video\])/is", $content, $matches_video );
        preg_match( "/{$start}(?:<p.*?>|)(\[wpvideo.*?\])/is", $content, $matches_wp_video );

        if( $matches_video ) {        
                $rest_content   = str_replace( $matches_video[1], '', $content);
                $output         = do_shortcode( $matches_video[1] );
        } else if( $matches_wp_video ) {
                $rest_content   = str_replace( $matches_wp_video[1], '', $content);
                $output         = do_shortcode( $matches_wp_video[1] );
        } else {
                $content = apply_filters( 'the_content', $content );
                
                preg_match( "/{$start}(?:<p.*?>|)(<iframe.*?<\/iframe>)/is", $content, $matches_iframe );
                
                if( $matches_iframe ) {
                    $output         = $matches_iframe[1];
                    $rest_content   = str_replace( $output, '', $content);
                }
        } 
        
        return $output;
}
endif; // warta_match_video



if( !function_exists( 'warta_match_audio' ) ) :
/**
 * Get audio content from a post
 * =============================================================================
 * @return string Audio html code
 */
function warta_match_audio( $start = '', &$rest_content = '' ) {
    
        $content    = get_the_content();
        $output     = '';
        
        preg_match("/{$start}(?:<p.*?>|)(\[audio.*?\[\/audio\])/i", $content, $matches_audio);
        if( !$matches_audio ) {
                preg_match("/{$start}(?:<p.*?>|)(\[audio.*?\]|\[playlist.*?\])/i", $content, $matches_audio);
        }
        
        if( !!$matches_audio ) {
                $output         = do_shortcode( $matches_audio[1] );
                $rest_content   = str_replace( $matches_audio[1], '', $content);                
        } 
        
        return $output;
}
endif; // warta_match_audio



if( !function_exists('warta_match_featured_media') ) : 
/**
 * Get featured media from a post
 * =============================================================================
 * @global type $wp_embed
 * @return string Featured media html code
 */
function warta_match_featured_media( $start = '', &$rest_content = '' ) {
        global $wp_embed;

        $content        = get_the_content();
        $output         = '';

        preg_match( "/{$start}(?:<p.*?>|)(\[embed.*?\[\/embed\])/is", $content, $matches_embed );
        
        if( !!$matches_embed ) {
                $rest_content   = str_replace( $matches_embed[1], '', $content);
                $matches_embed  = $wp_embed->run_shortcode($matches_embed[1]);  
        } else {
                $matches_embed  = '';
        }
        
        preg_match( '/<a.*?<\/a>/is', $matches_embed, $matches_link );          // check if embed shortcode returns link only  
        if( !!$matches_link && ( trim($matches_embed) == $matches_link[0] ) ) { // Is embed shortcode works?
                $matches_embed = '';
        } 
        
        preg_match( "/{$start}(?:<p.*?>|)(<embed.*?\<\/embed>)/is", apply_filters( 'the_content', $content ), $matches_embed_tag );

        if( $matches_embed ) {                
                $output         = $matches_embed;
        } else if( $matches_embed_tag ) { 
                $output         = $matches_embed_tag[1];
                $rest_content   = str_replace( $output, '', apply_filters( 'the_content', $content ) );
        } else {
                switch ( get_post_format() ) {
                        case 'video':
                                $output = warta_match_video( $start, $rest_content );
                                break;
                        case 'audio':
                                $output = warta_match_audio( $start, $rest_content );
                                break;
                }
        }
                
        return $output;
}
endif; // warta_match_featured_media