<?php

/**
 * Gallery functions
 * 
 * @package Warta
 */

if( !function_exists('warta_match_gallery') ) :
/**
 * Get information for featured image use
 * 
 * @param string $content Text to search for
 * @param int $id Post ID
 * @return array
 */
function warta_match_gallery( $content = '', $id = 0 ) {
    
        $content        = $content ? $content : get_the_content();
        $output         = array();

        preg_match_all('/\[(?:gallery|carousel).+?ids="([0-9 ,]+?)".*?\]/is', $content, $matches_gallery);
                        
        if( $matches_gallery[0] ) {
                $output['image_ids'] = array();
                
                foreach ( $matches_gallery[1] as $value) {
                        $output['image_ids'] = array_merge( 
                                $output['image_ids'],
                                explode( ',', $value )
                        );
                }        
                
        } else {
                $attachments = get_children( array(
                        'post_parent'       => !!$id ? $id : get_the_ID(), 
                        'post_status'       => 'inherit', 
                        'post_type'         => 'attachment', 
                        'post_mime_type'    => 'image', 
                ) );
                
                if( $attachments ) {
                        $output['image_ids'] = array_keys( $attachments );                        
                }
        }
                
        return $output;
    
} 
endif; // warta_match_gallery
