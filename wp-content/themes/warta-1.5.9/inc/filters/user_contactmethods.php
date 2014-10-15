<?php
/**
 * Add author contact filters
 * 
 * @package Warta
 */

if( !function_exists('warta_add_author_social_media') ) :
/**
 * Add author social media links
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @param type $contactmethods
 * @return string
 */
function warta_add_author_social_media( $user_contact  ) {    
    global $friskamax_warta_var;
    
    foreach ( $friskamax_warta_var['social_media'] as $key => $value) {
        if( $key == 'rss' )
                continue;
        
        $user_contact["friskamax_{$key}"] = "{$value} URL";
    }

    return $user_contact;
}
endif; // warta_add_author_social_media
add_filter( 'user_contactmethods', 'warta_add_author_social_media', 10, 1);