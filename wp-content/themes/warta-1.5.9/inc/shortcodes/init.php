<?php
/**
 * Initialize Shortcodes.
 *
 * @package Warta
 */

if(!function_exists('warta_after_wp_tiny_mce')) :
/**
 * Add shortcode modal forms after any core TinyMCE editor instances are created
 */
function warta_after_wp_tiny_mce() {
        $dir = dirname(__FILE__);
        require "$dir/modal/tabs.php";
        require "$dir/modal/accordion.php";
        require "$dir/modal/spoiler.php";
        
        FriskaMax_Helper::modal_font_awesome_select($GLOBALS['friskamax_warta_var']['font_awesome']);
}
endif; 
add_action('after_wp_tiny_mce', 'warta_after_wp_tiny_mce');



/**
 * Load Shorcodes
 */
require dirname(__FILE__) . '/columns.php';
require dirname(__FILE__) . '/dropcaps.php';
require dirname(__FILE__) . '/tabs.php';
require dirname(__FILE__) . '/accordion.php';
require dirname(__FILE__) . '/button.php';
require dirname(__FILE__) . '/label.php';
require dirname(__FILE__) . '/alert.php';
require dirname(__FILE__) . '/quote.php';
require dirname(__FILE__) . '/icons.php';
require dirname(__FILE__) . '/spoiler.php';
require dirname(__FILE__) . '/carousel.php';

// replace core shortcodes
require dirname(__FILE__) . '/gallery.php';



if( !function_exists('warta_register_tinymce_plugin') ) :
/**
 * Registering TinyMCE Plugin
 */
function warta_register_tinymce_plugin() {
        add_filter( "mce_external_plugins", "warta_add_buttons" );
        add_filter( 'mce_buttons_3', 'warta_register_buttons' );
}
endif; // warta_register_tinymce_plugin
add_action( 'init', 'warta_register_tinymce_plugin' );

/**
 * Add TinyMCE buttons
 * @param array $plugins Default plugins
 * @return array $plugins Default and custom plugins
 */
function warta_add_buttons( $plugins ) {
        $plugins['warta_shortcodes'] = get_template_directory_uri()  . '/inc/shortcodes/js/buttons.js';
        $plugins['table'] = get_template_directory_uri()  . '/inc/shortcodes/js/plugins/table.min.js';
        return $plugins;
}

if( !function_exists('warta_register_buttons') ) :
/**
 * Register TinyMCE buttons
 * @param array $buttons Default buttons
 * @return array $buttons Default and custom buttons
 */
function warta_register_buttons( $buttons ) {
        array_push( 
                $buttons, 
                'table',
                'warta_columns',
                'warta_dropcaps',
                'warta_small',
                'warta_button',
                'warta_label',
                'warta_alert',
                'warta_quote',
                'warta_embed',
                'warta_icons',
                'warta_tabs',
                'warta_accordion',
                'warta_carousel',
                'warta_spoiler',
                'warta_next_page'
        );
        return $buttons;
}
endif; // warta_register_buttons



/**
 * Register custom classes
 * @param array $arr_options
 * @return array $arr_options
 */
/*
function add_custom_classes($arr_options) {    
    $arr_options['theme_advanced_styles'] = ""
            . "Default=table table-hover;"
            . "Striped rows=table table-hover table-striped;"
            . "Bordered table=table table-hover table-bordered;"
            . "Bordered and striped=table table-hover table-striped table-bordered";
    return $arr_options;
}
add_filter('tiny_mce_before_init', 'add_custom_classes');
*/


if( !function_exists('warta_mce_translate') ) :
/**
 * Get TinyMCE translation
 * @param array $arr
 * @return array $arr
 */
function warta_mce_translate( $arr )
{
        $arr[] = dirname(__FILE__) . '/lang/lang.php';
        return $arr;
}
endif; // warta_mce_translate
add_filter( 'mce_external_languages', 'warta_mce_translate' );