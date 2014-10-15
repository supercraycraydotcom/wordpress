<?php

require dirname(__FILE__) . '/class-friskamax-helper.php';

if(!function_exists('friskamax_helper_init')) :
        function friskamax_helper_init() {
                wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );
                wp_enqueue_style( 'fsmh-style', get_template_directory_uri() . '/inc/friskamax-helper/css/fsmh.css'  );
                wp_enqueue_script( 'fsmh-script', get_template_directory_uri() . '/inc/friskamax-helper/js/fsmh.js' , array('jquery'), time(), TRUE);
        }
endif;

add_action( 'load-post.php', 'friskamax_helper_init' );
add_action( 'load-post-new.php', 'friskamax_helper_init' );
add_action( 'sidebar_admin_page', 'friskamax_helper_init' );

FriskaMax_Helper::$text_domain = 'warta';