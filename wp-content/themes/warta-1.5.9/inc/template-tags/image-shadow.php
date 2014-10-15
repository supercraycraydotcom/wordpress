<?php
/**
 * Returns image shadow HTML
 * 
 * @package Warta
 */

if ( ! function_exists( 'warta_image_shadow' ) ) :
/**
 * Returns image shadow HTML.
 */
function warta_image_shadow() {    
    return '<img src="' . get_template_directory_uri() . '/img/shadow.png" class="shadow" alt="shadow">';
}
endif;