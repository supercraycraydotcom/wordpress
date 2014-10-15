<?php

if(!function_exists('warta_html_class')) : 
        /**
         * Print html classes
         * @global array $friskamax_warta
         */
        function warta_html_class() {
                global  $friskamax_warta;
                
                $html_class = '';
                
                if( isset($friskamax_warta['boxed_style']) && $friskamax_warta['boxed_style'] ) { 
                        $html_class .= 'boxed-style ';
                }
                if( isset($friskamax_warta['flat_style']) && $friskamax_warta['flat_style'] ) { 
                        $html_class .= 'flat-style ';
                }
                if( isset($friskamax_warta['image_light']) && !$friskamax_warta['image_light'] ) {
                        $html_class .= 'no-image-light ';
                }
                if( isset($friskamax_warta['zoom_effect']) && !$friskamax_warta['zoom_effect'] ) {
                        $html_class .= 'no-zoom-effect ';
                }
                if( isset($friskamax_warta['ajax_post_views']) && $friskamax_warta['ajax_post_views'] ) {
                        $html_class .= 'ajax-post-views ';
                }
                
                echo $html_class;
        }
endif;