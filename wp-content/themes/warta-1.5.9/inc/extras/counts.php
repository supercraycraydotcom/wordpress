<?php
/**
 * Counts functions
 * 
 * @package Warta
 */

if( !function_exists( 'warta_format_counts' ) ) :
/**
 * Format high value counts number
 * @param int $number
 * @return string
 */
function warta_format_counts( $number ) {
        if( $number >= 1000000 )
                $number = floor( $number / 1000000 ) . 'm';
        elseif( $number >= 1000 )
                $number = floor( $number / 1000 ) . 'k';
        
        return $number;
}
endif; // warta_format_counts