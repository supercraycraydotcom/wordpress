<?php
/**
 * Custom redux validation
 * 
 * @package Warta
 */

if (!function_exists('warta_validate_unfiltered_html')):
/**
 * Validate unfiltered HTML
 * -----------------------------------------------------------------------------
 */
function warta_validate_unfiltered_html($field, $value, $existing_value) {
        $error = false;
        
        if ( current_user_can('unfiltered_html') ) {
                $return['value']    = $value;
        } else {
                $error              = true;                
                $return['value']    = $existing_value;
                $field['msg']       = __("You don't have the right to post HTML markup or JavaScript code", 'warta');
        }

        if ($error == true) {
                $return['error'] = $field;
        }
        
        return $return;
}
endif; // warta_validate_unfiltered_html



if( !function_exists( 'warta_validate_integer' ) ):
/**
 * Validate integer
 * -----------------------------------------------------------------------------
 */
function warta_validate_integer($field, $value, $existing_value) {   
        if( is_array($value) ) {
                foreach ($value as $key => $value) {
                        $return['value'][$key] = (int) $value;
                }
        } else {
                $return['value'] = (int) $value;
        }
        
        return $return;
}
endif; // warta_validate_integer