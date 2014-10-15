<?php

if( !function_exists('warta_js_code')):
function warta_js_code() {
        global $friskamax_warta;
        
        if( isset( $friskamax_warta['js_code'] ) && !!trim( $friskamax_warta['js_code'] ) ) 
                echo "<script>{$friskamax_warta['js_code']}</script>";
                
        if( isset( $friskamax_warta['tracking_code'] ) && !!trim( $friskamax_warta['tracking_code'] ) ) 
                echo $friskamax_warta['tracking_code'];
}
endif; // warta_ie8_support
add_action('wp_footer', 'warta_js_code', 666);

