<?php
/**
 * Excerpt filters
 * 
 * @package Warta
 */

if( !function_exists('warta_excerpt_length') ) :
/**
 * Change default excerpt length that are 55 words to 256 words
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @param int $length
 * @return int
 */
function warta_excerpt_length($length) {
    return 256;
}
endif; // warta_excerpt_length
add_filter('excerpt_length', 'warta_excerpt_length');



if( !function_exists('warta_excerpt_more') ) :
/**
 * Change default excerpt more [...] to ...
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * @param string $more Default excerpt more
 * @return string
 */
function warta_excerpt_more($more) {
    return ' &hellip;';
}
endif; // warta_excerpt_more
add_filter('excerpt_more', 'warta_excerpt_more');