<?php
/**
 * Custom functions
 */
function fbOpenGraph() {
    global $post;

    if (!empty($post->ID)) {
        ?>
        <meta property="og:title" content="<?php echo get_the_title($post->ID)?>">
        <meta property="og:image" content="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0]; ?>">
        <meta property="og:url" content="<?php echo get_permalink($post->ID); ?>">
        <?php
    }
}
add_action('wp_head', 'fbOpenGraph');

function headerPixels() {
    include dirname(__FILE__) . '/partials/header-pixels.php';
}
add_action('wp_head', 'headerPixels');




/**
 * Warta functions and definitions
 *
 * @package Warta
 */

// Load Warta Theme variables
require get_template_directory() . '/inc/variable.php';



// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
        $content_width = 750; /* pixels */
}



if ( ! function_exists( 'warta_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function warta_setup() {                
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Warta, use a find and replace
         * to change 'warta' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'warta', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        // Declaring WooCommerce Support 
        add_theme_support( 'woocommerce' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        //add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'top'   => __( 'Top Menu', 'warta' ),
            'main'  => __( 'Main Menu', 'warta' ),
            'footer'=> __( 'Footer Menu', 'warta' ),
        ) );

        // Enable support for Post Formats.
        add_theme_support( 'post-formats', array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat',
            'noad',
        ));

        // Enabling Support for Post Thumbnails
        add_theme_support( 'post-thumbnails' ); 
        
        // Registers a new image size
        add_image_size('small', 165, 90, TRUE);
        add_image_size('gallery', 180, 180, TRUE);
        add_image_size('huge', 1366, 768, TRUE);
}
endif; // warta_setup
add_action( 'after_setup_theme', 'warta_setup' );



if(!function_exists('warta_after_switch_theme')) :
        /**
         * Set some settings after switch to this theme
         */
        function warta_after_switch_theme() {
                // Update Reserved Image Sizes
                update_option('thumbnail_size_w', 95);
                update_option('thumbnail_size_h', 75);
                update_option('thumbnail_crop', 1);
                update_option('medium_size_w', 350);
                update_option('medium_size_h', 185);
                update_option('medium_crop', 1);
                update_option('large_size_w', 730);
                update_option('large_size_h', 370);
                update_option('large_crop', 1);
                
                /* enable/disable tracking on Redux Framework option panel */
                $framework_options = get_option('redux-framework-tracking'); // get the array
                $framework_options['allow_tracking'] = 'no'; // set the value to yes or no
                update_option('redux-framework-tracking', $framework_options); // update the array
        }
endif;
add_action("after_switch_theme", "warta_after_switch_theme");



if( !function_exists('warta_scripts') ) :
/**
 * Enqueue scripts and styles.
 */
function warta_scripts() {                    
        if(file_exists(get_template_directory() . "/css/warta-wp.css")) {
                // Primary file
                wp_enqueue_style( 'warta-style', get_template_directory_uri() . "/css/warta-wp.css"  );
        } else {
                // Backup file
                wp_enqueue_style( 'warta-style', get_template_directory_uri() . "/css/style.min.css"  );
        }
        wp_enqueue_style('custom-styles', get_template_directory_uri() . '/css/custom.css', array(), '3.8.1');
        
        if(is_rtl()) {
                wp_enqueue_style( 'warta-style-rtl', get_template_directory_uri() . '/css/rtl.min.css', array('warta-style')  );
        }
        if(is_child_theme()) {
                wp_enqueue_style( 'warta-style-child', get_stylesheet_uri(), array('warta-style') );
        }
        
        wp_enqueue_script( 'warta-script', get_template_directory_uri() . '/js/script.min.js' , array('jquery', 'jquery-ui-core', 'jquery-effects-core'), time(), TRUE);
        wp_enqueue_script( 'warta-script-init', get_template_directory_uri() . '/js/init.min.js' , array(), time(), TRUE);
        
        // Ajax
        wp_localize_script( 'warta-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        
        wp_enqueue_script( 'warta-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), time(), true );
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
}
endif; // warta_scripts
add_action( 'wp_enqueue_scripts', 'warta_scripts' );



if( !function_exists('warta_init_actions') ) :
function warta_init_actions() { 
        // Adds editorstyle 
        add_editor_style( 'css/editor.css');
        
        // Start session
        if( !session_id() ) {
                session_start();
        }
}
endif; // warta_init_actions
add_action('init','warta_init_actions');



// Custom functions that act independently of the theme templates
require get_template_directory() . '/inc/extras/load.php';
require get_template_directory() . '/inc/extras.php';

// Loads FriskaMax Helper
require get_template_directory() . '/inc/friskamax-helper/init.php';
 
// Loads Friskamax Page builder
require get_template_directory() . '/inc/friskamax-page-builder/init.php';

// Load filters
require get_template_directory() . '/inc/filters/load.php';

// Register widgets and widgets area.
require get_template_directory() . '/inc/widgets/init.php';

// Add meta boxes
require get_template_directory() . '/inc/meta-boxes/init.php';

// Add shortcodes
require get_template_directory() . '/inc/shortcodes/init.php';

// Load deprecated features
if( file_exists( get_template_directory() . '/deprecated/init.php' ) ) {
        require_once get_template_directory() . '/deprecated/init.php';
}

// Initialize ReduxFramework
if ( !class_exists( 'ReduxFramework' ) ) {
        require_once( get_template_directory() . '/inc/admin/redux-framework/ReduxCore/framework.php' );
}
if ( !isset( $friskamax_warta ) ) {
        require_once( get_template_directory() . '/inc/admin/redux-config.php' );
}

// Load custom navwalker
require get_template_directory() . '/inc/warta_bootstrap_navwalker.php';

// Custom template tags for this theme
require get_template_directory() . '/inc/template-tags/load.php';

// Load ajax functions
require get_template_directory() . '/inc/ajax/load.php';

// Load customizer
//if( file_exists( get_template_directory() . '/customizer/init.php' ) ) {
//        require_once get_template_directory() . '/customizer/init.php';
//}
