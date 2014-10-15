<?php
/**
 * Initialize Meta Boxes.
 *
 * @package Warta
 */

if(!function_exists('warta_fsmpb_element_widget_area__sidebar_args')) :
        /**
         * Set custom sidebar args
         * @param array $sidebar_args
         * @return array
         */
        function warta_fsmpb_element_widget_area__sidebar_args($sidebar_args) {        
                $sidebar_args['main'] = wp_parse_args(
                        array(
                                'before_widget' => '<section id="%1$s" class="col-md-12 widget %2$s">',
                                'after_widget'  => '</section>',
                                'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
                                'after_title'   => '</h4></header>',
                        ),
                        $sidebar_args['main']
                );                                
                return $sidebar_args;
        }
endif;
add_filter('fsmpb_element_widget_area__sidebar_args', 'warta_fsmpb_element_widget_area__sidebar_args');




// Load Meta Boxes Classes
require dirname(__FILE__) . '/full-carousel.php';
require dirname(__FILE__) . '/review.php';  
require dirname(__FILE__) . '/title-bg.php';  
require dirname(__FILE__) . '/sidebar.php';   
require dirname(__FILE__) . '/display-options.php';  

if( !function_exists('warta_meta_boxes_init') ) :
/**
 * Calls the class on the post edit screen.
 */
function warta_meta_boxes_init() {
        new Warta_Full_Width_Carousel_Meta_Box();
        new Warta_Review_Meta_Box();
        new Warta_Page_Title_BG_Meta_Box();
        new Warta_Sidebar_Meta_Box();
        new Warta_Display_Options_Meta_Box();
        
        wp_enqueue_script( 'warta-meta-boxes', get_template_directory_uri() . '/js/admin/meta-boxes.js' , array('jquery'), time(), TRUE);
}
endif;
if ( is_admin() ) {
        add_action( 'load-post.php', 'warta_meta_boxes_init' );
        add_action( 'load-post-new.php', 'warta_meta_boxes_init' );
}




/**
 * PAGE BUILDER
 * ============
 */
// Initialize page builder
new Fsmpb_Meta_Box( array(
        'text_domain'           => 'warta',
        'custom_element_classes'=> array('Fsmpb_Element_Widget_Area')
) );

if(!function_exists('warta_fsmpb_register_elements')) :        
/**
 * Register Page Builder elements
 * @param object $fsmpb
 */
function warta_fsmpb_register_elements($fsmpb) {        
        $fsmpb_helper = new Fsmpb_Helper();
        
        // Warta widget classes
        $warta_widget_classes = array(
                'Warta_Advertisement',
                'Warta_Articles',
                'Warta_Breaking_News',
                'Warta_Feedburner',
                'Warta_Flickr_Feed',
                'Warta_Gallery_Carousel',
                'Warta_Posts_Carousel',
                'Warta_Slider_Tabs',
                'Warta_Social_Media',
                'Warta_Sub_Categories',
                'Warta_Tabs',
                'Warta_Text_Editor',
         );                
        if( Warta_Helper::isset_twitter_api() ) {
                $warta_widget_classes[] = 'Warta_Twitter_Feed';
                asort($warta_widget_classes); 
        }             

        // Page builder tabs
        $fsmpb->tabs = array(
                'fsmpb-elements--warta-widgets' => array(
                                                        'name'  => __('Warta Widgets', 'warta'),                
                                                        'items' => $fsmpb_helper->get_element_args__widget($warta_widget_classes)
                                                ),
                'fsmpb-tab--wp-widgets'         => array(
                                                        'name'  => __('WordPress Widgets', 'warta'),
                                                        'items' => $fsmpb_helper->get_element_args__wp_widgets()
                                                )

        );
        if(!!$plugin_widgets_args = $fsmpb_helper->get_element_args__plugin_widgets()) {
                $fsmpb->tabs['fsmpb-tab--plugin-widgets'] = array(
                        'name'          => __('Plugin Widgets', 'warta'),
                        'note'          => __("Note: widgets in this tab may not work properly. "
                                        . "If it doesn't work, please use <strong>Widget Area</strong> instead. "
                                        . "You can find it in tab <strong>Other</strong>.", 'warta'),
                        'items'         => $plugin_widgets_args
                );
        }
        $fsmpb->tabs['fsmpb-elements--other'] =  array(
                'name'  => __('Other', 'warta'),                
                'items' => array( 
                                array(
                                        'type'                  => 'custom',
                                        'title'                 => __('Widgets Area', 'warta'),
                                        'description'           => __('An area that you can add widgets in it from <strong>Appearance > Widgets</strong>', 'warta'),
                                        'php_class'             => 'Fsmpb_Element_Widget_Area',
                                ) 
                        )
        );        
}
endif;
add_action('fsmpb_register_elements', 'warta_fsmpb_register_elements');