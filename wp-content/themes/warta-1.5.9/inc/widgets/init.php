<?php
/**
 * Warta widgets initialization
 *
 * @package Warta
 */

/**
 * Load widgets
 * ============
 */
require get_template_directory() . '/inc/widgets/base.php';
require get_template_directory() . '/inc/widgets/slider-tabs.php';
require get_template_directory() . '/inc/widgets/breaking-news.php';
require get_template_directory() . '/inc/widgets/articles.php';
require get_template_directory() . '/inc/widgets/ads.php';
require get_template_directory() . '/inc/widgets/social-media.php';
require get_template_directory() . '/inc/widgets/gallery-carousel.php';
require get_template_directory() . '/inc/widgets/posts-carousel.php';
require get_template_directory() . '/inc/widgets/feedburner.php';
require get_template_directory() . '/inc/widgets/tabs.php';
require get_template_directory() . '/inc/widgets/flickr-feed.php';
require get_template_directory() . '/inc/widgets/sub-categories.php';
require get_template_directory() . '/inc/widgets/twitter-feed.php';
require get_template_directory() . '/inc/widgets/text-editor.php';


if( !function_exists('warta_widgets_init')) : 
function warta_widgets_init() {  
        $friskamax_warta = get_option('friskamax_warta');
    
        /**
         * Register widgets
         * ================
         */
        register_widget( 'Warta_Slider_Tabs' );
        register_widget( 'Warta_Breaking_News' );
        register_widget( 'Warta_Articles' );
        register_widget( 'Warta_Advertisement' );
        register_widget( 'Warta_Social_Media' );
        register_widget( 'Warta_Gallery_Carousel' );
        register_widget( 'Warta_Posts_Carousel' );
        register_widget( 'Warta_Feedburner' );
        register_widget( 'Warta_Tabs' );
        register_widget( 'Warta_Flickr_Feed' );
        register_widget( 'Warta_Sub_Categories' );
        register_widget( 'Warta_Text_Editor' );
        
        if( Warta_Helper::isset_twitter_api()  ) {
                register_widget( 'Warta_Twitter_Feed' );
        }
        
        
        
        /**
         * Register widgetized area
         * ========================
         */        
            
        /**
         * Before Content
         * --------------
         */    
        register_sidebar( array(
                 'name'          => __( 'Before Content - Archive Page', 'warta' ),
                 'description'   => __( 'Appears on top main section of archive page.', 'warta' ),
                 'id'            => 'archive-before-content-section',
                 'before_widget' => '<section id="%1$s" class="col-md-12 widget %2$s">',
                 'after_widget'  => '</section>',
                 'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
                 'after_title'   => '</h4></header>',
        ) );    
        register_sidebar( array(
            'name'          => __( 'Before Content - Single Post Page', 'warta' ),
            'description'   => __( 'Appears on top main section of single post page.', 'warta' ),
            'id'            => 'singular-before-content-section',
            'before_widget' => '<section id="%1$s" class="col-md-12 widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
            'after_title'   => '</h4></header>',
        ) );
    
        /**
         * After Content
         * -------------
         */    
        register_sidebar( array(
            'name'          => __( 'After Content - Archive Page', 'warta' ),
            'description'   => __( 'Appears on bottom main section of archive page (above pagination).', 'warta' ),
            'id'            => 'archive-after-content-section',
            'before_widget' => '<section id="%1$s" class="col-md-12 widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
            'after_title'   => '</h4></header>',
        ) );    
        register_sidebar( array(
            'name'          => __( 'After Content - Single Post Page', 'warta' ),
            'description'   => __( 'Appears on main section of single post page below post content (or author info if any).', 'warta' ),
            'id'            => 'singular-after-content-section',
            'before_widget' => '<section id="%1$s" class="col-md-12 widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
            'after_title'   => '</h4></header>',
        ) );
    
            
        /**
         * Sidebar Sections
         * ----------------
         */
        register_sidebar( array(
                'name'          => __( 'Sidebar Section - Default', 'warta' ),
                'description'   => __( 'Appears in the sidebar section (next to main section) of all pages. Can be replaced with custom widgets area.', 'warta' ),
                'id'            => 'default-sidebar-section',
                'before_widget' => '<section id="%1$s" class="col-sm-6 col-md-12 widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
                'after_title'   => '</h4></header>',
        ) );    
        $sidebar = array(
                'archive_specific_widget'   => array( 
                                                        'id'    => 'archive-sidebar-section',
                                                        'name'  => 'Archive Page',
                                                        'desc'  => __( 'Appears in the sidebar section (next to main section) of archive page. Replaces "Sidebar Section - Default".', 'warta' )
                                            ),
                'singular_specific_widget'  => array( 
                                                        'id'    => 'singular-sidebar-section',
                                                        'name'  => 'Single Post Page',
                                                        'desc'  => __( 'Appears in the sidebar section (next to main section) of single post page. Replaces "Sidebar Section - Default".', 'warta' )
                                            ),
                'page_specific_widget'      => array( 
                                                        'id'    => 'page-sidebar-section',
                                                        'name'  => 'Static Page',
                                                        'desc'  => __( 'Appears in the sidebar section (next to main section) of static page. Replaces "Sidebar Section - Default".', 'warta' )
                                            ),
        );    
        foreach ($sidebar as $key => $value) {
                if( isset( $friskamax_warta[$key]['sidebar'] ) && $friskamax_warta[$key]['sidebar'] == 1 ) {
                        register_sidebar( array(
                                'name'          => sprintf( __( "Sidebar Section - %s", 'warta' ), $value['name'] ),
                                'id'            => $value['id'],
                                'description'   => $value['desc'],
                                'before_widget' => '<section id="%1$s" class="col-sm-6 col-md-12 widget %2$s">',
                                'after_widget'  => '</section>',
                                'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
                                'after_title'   => '</h4></header>',
                        ) );
                }
        }    
            
    
        /**
         * Footer Sections
         * ---------------
         */    
        register_sidebar( array(
                'name'          => __( 'Footer Section - Default', 'warta' ),
                'id'            => 'default-footer-section',
                'description'   => __( 'Appears in the footer section of all pages. Can be replaced with custom widgets area.', 'warta' ),
                'before_widget' => $friskamax_warta['footer_layout'] == 1 
                                ? '<section id="%1$s" class="widget col-md-2 col-sm-4 %2$s">'
                                : '<section id="%1$s" class="widget col-md-3 col-sm-6 %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="title"><h4 class="widget-title">',
                'after_title'   => '</h4></div>',
        ) );    
        $footer = array(
                'archive_specific_widget'   => array( 
                                                        'id'            => 'archive-footer-section',
                                                        'name'          => 'Archive Page',
                                                        'before_widget' => $friskamax_warta['archive_footer_layout'] == 1 
                                                                        ? '<section id="%1$s" class="widget col-md-2 col-sm-4 %2$s">'
                                                                        : '<section id="%1$s" class="widget col-md-3 col-sm-6 %2$s">',
                                                        'desc'          => __( 'Appears in the footer section of archive page. Replaces "Footer Section - Default".', 'warta' )
                                            ),
                'singular_specific_widget'  => array( 
                                                        'id'            => 'singular-footer-section',
                                                        'name'          => 'Single Post Page',
                                                        'before_widget' => $friskamax_warta['singular_footer_layout'] == 1 
                                                                        ? '<section id="%1$s" class="widget col-md-2 col-sm-4 %2$s">'
                                                                        : '<section id="%1$s" class="widget col-md-3 col-sm-6 %2$s">',
                                                        'desc'          => __( 'Appears in the footer section of single post page. Replaces "Footer Section - Default".', 'warta' )
                                            ),
                'page_specific_widget'      => array( 
                                                        'id'            => 'page-footer-section',
                                                        'name'          => 'Static Page',
                                                        'before_widget' => $friskamax_warta['page_footer_layout'] == 1 
                                                                        ? '<section id="%1$s" class="widget col-md-2 col-sm-4 %2$s">'
                                                                        : '<section id="%1$s" class="widget col-md-3 col-sm-6 %2$s">',
                                                        'desc'          => __( 'Appears in the footer section of static page. Replaces "Footer Section - Default".', 'warta' )
                                            ),
        );    
        foreach ($footer as $key => $value) {
                if( isset( $friskamax_warta[$key]['footer'] ) && $friskamax_warta[$key]['footer'] == 1 ) {
                        register_sidebar( array(
                                'name'          => sprintf( __( "Footer Section - %s", 'warta' ), $value['name'] ),
                                'id'            => $value['id'],
                                'before_widget' => $value['before_widget'],
                                'description'   => $value['desc'],
                                'after_widget'  => '</section>',
                                'before_title'  => '<div class="title"><h4 class="widget-title">',
                                'after_title'   => '</h4></div>',
                        ) );
                }
        }    
}
endif; // warta_widgets_init
add_action( 'widgets_init', 'warta_widgets_init' );