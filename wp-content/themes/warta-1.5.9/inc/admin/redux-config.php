<?php
if (!class_exists("Redux_Framework_warta")) :
class Redux_Framework_warta {        
        public $args            = array();
        public $sections        = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
                if (!class_exists('ReduxFramework')) {
                        return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                        $this->initSettings();
                } else {
                        add_action('plugins_loaded', array($this, 'initSettings'), 10);
                }     
        }
        
        public function initSettings() {
                if ( !class_exists("ReduxFramework" ) ) {
                        return;
                }       
            
                // Set the default arguments
                $this->setArguments();

                // Create the sections and fields
                $this->setSections();

                if (!isset($this->args['opt_name'])) { // No errors please
                        return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
                // Function to test the compiler hook and demo CSS output.
                add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2 ); 
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
                
                add_action( 'redux/page/' . $this->args['opt_name'] . '/enqueue', array($this, 'add_panel_css') ); // Adds custom css
                add_action( "after_switch_theme", array($this, 'after_switch_theme')); // after switch theme actions

                $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        
        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {
                $this->args = array(
                        // TYPICAL -> Change these values as you need/desire
                        'opt_name'              => 'friskamax_warta',           // This is where your data is stored in the database and also becomes your global variable name.
                        'display_name'          => __( 'Warta Theme Options', 'warta' ),         // Name that appears at the top of your panel
                        'display_version'       => '',                          // Version that appears at the top of your panel
                        'menu_type'             => 'menu',                      //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                        'allow_sub_menu'        => FALSE,                       // Show the sections below the admin menu item or not
                        'menu_title'            => 'Warta',
                        'page_title'            => __( 'Warta Theme Options', 'warta' ),
                        // You will need to generate a Google API key to use this feature.
                        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                        'google_api_key'        => '',                          // Must be defined to add google fonts to the typography module
                        //'admin_bar'           => false,                       // Show the panel pages on the admin bar
                        'global_variable'       => '',                          // Set a different name for your global variable other than the opt_name
                        'dev_mode'              => FALSE,                       // Show the time the page took to load, etc
                        'customizer'            => FALSE,                       // Enable basic customizer support
                        // OPTIONAL -> Give you extra features
                        'page_priority'         => null,                        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                        'page_parent'           => 'themes.php',                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                        'page_permissions'      => 'manage_options',            // Permissions needed to access the options panel.
                        'menu_icon'             => '',                          // Specify a custom URL to an icon
                        'last_tab'              => '',                          // Force your panel to always open to a specific tab (by id)
                        'page_icon'             => 'icon-themes',               // Icon displayed in the admin panel next to your menu_title
                        'page_slug'             => 'warta-options',             // Page slug used to denote the panel
                        'save_defaults'         => true,                        // On load save the defaults to DB before user clicks save or not
                        'default_show'          => false,                       // If true, shows the default value next to each field that is not the default value.
                        'default_mark'          => '',                          // What to print by the field's title if the value shown is default. Suggested: *
                        // CAREFUL -> These options are for advanced use only
                        'transient_time'        => 60 * MINUTE_IN_SECONDS,
                        'output'                => true,                        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                        'output_tag'            => true,                        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                        //'domain'             	=> 'redux-framework',           // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                        'footer_credit'      	=> ' ',                          // Disable the footer credit of Redux. Please leave if you can help it.
                        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                        'database'              => '',                          // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                        'show_import_export'    => TRUE,                       // REMOVE
                        'system_info'           => false,                       // REMOVE
                        'help_tabs'             => array(),
                        'help_sidebar'          => '',                          // __( '', $this->args['domain'] );            
                );       
                
                $friskamax_warta = get_option('friskamax_warta');
                if( !!$friskamax_warta && isset($friskamax_warta['typography_google_api_key']) ) {
                        $this->args['google_api_key'] = $friskamax_warta['typography_google_api_key'];
                }
        }
        
        public function setSections() {
                global $friskamax_warta_var;
                
                $dir = dirname(__FILE__);
                
                require $dir . '/general.php';      
                require $dir . '/appearance.php';      
                require $dir . '/typography.php';      
        
                $this->sections[] = array( 'type' => 'divide' );

                require $dir . '/archive.php';  
                require $dir . '/singular.php';  
                require $dir . '/gallery-page.php';  
                require $dir . '/static-page.php';  
                require $dir . '/contact-page.php';  

                $this->sections[] = array( 'type' => 'divide' );

                require $dir . '/top-menu.php';
                require $dir . '/review-box.php';     
                require $dir . '/twitter.php';     

                $this->sections[] = array( 'type' => 'divide' );

                require $dir . '/advanced.php';     
        }
         
       /**
        * Add custom css files
        * ====================
        */
        function add_panel_css() {
                if(is_rtl()) {
                       wp_enqueue_style( 'redux-custom-css-rtl', get_template_directory_uri() . '/css/admin/redux-rtl.css', array( 'redux-css' ) );
                }
                // wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css');  
                
                wp_enqueue_script('redux-custom-js', get_template_directory_uri() . '/js/admin/redux.js', array('jquery', 'iris'), time(), TRUE);
        }
        
        /**
         * Admin notice
         * ============
         */
        function admin_notice() {
?>
                <div class="error">
                        <p><?php echo $this->admin_notice ?></p>
                </div>
<?php
        }
        
        /**

          Less compiler.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css = NULL) {                
                global $wp_filesystem;
                                
                $input          = get_template_directory() . '/css/less/style.less';
                $output         = get_template_directory() . '/css/warta-wp.css';
                
                // Check file permission
                if( file_exists($output) && !is_writable($output) ) {    
                        $this->admin_notice = wp_kses_post( sprintf( __('Cannot write css file. %s must writable! Please change the permission to 644', 'warta'), $output ) );
                        add_action( 'admin_notices', array($this, 'admin_notice') ); 
                } else if ( !is_writable( dirname($output) ) ) {                        
                        $this->admin_notice = wp_kses_post( sprintf( __('Cannot write css file. %s must writable! Please change the permission to 755', 'warta'), dirname($output) ) );
                        add_action( 'admin_notices', array($this, 'admin_notice') );                            
                }  
                                
                if(!class_exists('Less_Parser')) {
                        require_once get_template_directory() . '/inc/less-php/Less.php';
                }                
                $parser = new Less_Parser(array( 
                        'compress'      => true,
                        'relativeUrls'  => false
                ));
                $parser->parseFile( $input );
                $parser->ModifyVars(array(
                        'primary'               => $options['primary-color'],
                        'secondary'             => $options['secondary-color'],
                        'headings-link-color'   => $options['headings-link-color'],
                        'body-link-color'       => $options['body-link-color'],
                ));
                $css = $parser->getCss();
                
                if( empty( $wp_filesystem ) ) {
                        require_once( ABSPATH .'/wp-admin/includes/file.php' );
                        WP_Filesystem();
                }                
                if(!!$wp_filesystem && !!$css) {
                        $wp_filesystem->put_contents(
                                $output,
                                $css,
                                FS_CHMOD_FILE // predefined mode settings for WP files
                        );
                }
        }
        
        /**
         * Actions that run after_switch_theme
         */
        function after_switch_theme() {
                // Compile the less files
                $options = $this->ReduxFramework->options;                
                if( 
                        isset($options['primary-color'])        && !!$options['primary-color']          &&
                        isset($options['secondary-color'])      && !!$options['secondary-color']        &&
                        isset($options['headings-link-color'])  && !!$options['headings-link-color']    && 
                        isset($options['body-link-color'])      && !!$options['body-link-color'] 
                ) {
                        $this->compiler_action($options);
                }
        }
}
new Redux_Framework_warta();
endif; // Redux_Framework_warta

/**
 * Add FontAwesome Select Icons Options
 * ====================================
 */
/*
if( !function_exists('warta_font_awesome_select') ) :
function warta_font_awesome_select($field) {
        if( !class_exists( 'ReduxFramework_warta_font_awesome_select' ) ) :
                class ReduxFramework_warta_font_awesome_select extends ReduxFramework_select {
                        function render(){
                                global $friskamax_warta_var;

                                echo '<select '
                                            . 'id="'.$this->field['id'].'-select"  '
                                            . 'name="' . $this->field['name'] . $this->field['name_suffix'] . '" '
                                            . 'class="redux-select-item font-icons'.$this->field['class'].'" '
                                            . 'rows="10"'
                                            . 'data-placeholder="'.__('Select an icon', 'warta').'">';
                                echo '<option></option>';

                                foreach( $friskamax_warta_var['font_awesome'] as $value) {
                                        echo "<option value='fa {$value}' " . selected($this->value, "fa {$value}", false) . "> {$value}</option>";
                                }

                                echo '</select>';	
                        }
                }
        endif;
}
endif; // warta_font_awesome_select
add_filter( "redux/friskamax_warta/field/class/warta_font_awesome_select", "warta_font_awesome_select" ); // Adds the local field
 *
 */