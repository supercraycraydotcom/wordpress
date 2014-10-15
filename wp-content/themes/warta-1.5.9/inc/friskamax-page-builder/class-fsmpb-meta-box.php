<?php
/**
 * FriskaMax Page Builder Meta Box
 * 
 * @author Fahri Rusliyadi
 */

if(!class_exists('Fsmpb_Meta_Box')) :
        class Fsmpb_Meta_Box {        
                /**
                 * The tabs
                 * @var array
                 */
                public $tabs = array();
                                
                /**
                 * Domain to retrieve the translated text
                 * @var string
                 */
                protected $text_domain;
                
                /**
                 * Custom element classes, should has method: form, sanitize and display
                 * @var array
                 */
                protected $custom_element_classes;
                
                
                
                
                /**
                 * =================
                 * REGISTER META BOX
                 * =================
                 */
                
                public function register() {
                        do_action('fsmpb_register_elements', $this);
                        
                        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
                        add_action( 'save_post', array( $this, 'save' ) );

                        $this->enqueue_scripts();
                        $this->localize();                        
                }

                /**
                 * Adds the meta box container.
                 */
                public function add_meta_box( $post_type ) {
                        $post_types = array(/* 'post', */ 'page');     //limit meta box to certain post types
                        if ( in_array( $post_type, $post_types )) {
                                add_meta_box(
                                        'fsmpb_meta_box'
                                        ,__( 'Page Builder', $this->text_domain )
                                        ,array( $this, 'display' )
                                        ,$post_type
                                        ,'normal'
                                        ,'high'
                                );
                        }
                }

                /**
                 * Save the meta when the post is saved.
                 *
                 * @param int $post_id The ID of the post being saved.
                 */
                public function save( $post_id ) {

                        /*
                         * We need to verify this came from the our screen and with proper authorization,
                         * because save_post can be triggered at other times.
                         */

                        // Check if our nonce is set.
                        if ( ! isset( $_POST['fsmpb_meta_box_nonce'] ) ) {
                                return $post_id;
                        }
                        $nonce = $_POST['fsmpb_meta_box_nonce'];

                        // Verify that the nonce is valid.
                        if ( ! wp_verify_nonce( $nonce, 'fsmpb_meta_box' ) ) {
                                return $post_id;
                        }

                        // Check the user's permissions.
                        if ( 'page' == $_POST['post_type'] && !current_user_can( 'edit_page', $post_id ) ) {
                                    return $post_id;
                        } else if ( !current_user_can( 'edit_post', $post_id ) ) {
                                return $post_id;
                        }    

                        /* OK, its safe for us to save the data now. */

                        // Sanitize the user input.
                        $data   = current_user_can('unfiltered_html') 
                                ? $_POST['fsmpb_main'] 
                                : stripslashes( wp_filter_post_kses( addslashes($_POST['fsmpb_main']) ) ); // wp_filter_post_kses() expects slashed;

                        // Update the meta field.
                        update_post_meta( $post_id, 'fsmpb_main', $data );
                }

                /**
                 * Enqueue js and css files
                 */
                protected function enqueue_scripts() {                                
                        wp_enqueue_style('fsmpb-style', get_template_directory_uri() . '/inc/friskamax-page-builder' . '/css/style.css');
                        wp_enqueue_script(
                                'fsmpb-script', 
                                get_template_directory_uri() . '/inc/friskamax-page-builder' . '/js/script.js', 
                                array(
                                        'jquery',
                                        'jquery-ui-core',
                                        'jquery-ui-widget',
                                        'jquery-ui-mouse',
                                        'fsmh-script'
                                ), 
                                time(), 
                                TRUE
                        );
                }

                /**
                 * Localize translation texts
                 */
                protected function localize() {
                        wp_localize_script(
                                'fsmpb-script', 
                                'fsmpbLang', 
                                array(
                                        'pageBuilder'           => __('Page Builder', $this->text_domain),
                                        'exitPageBuilder'       => __('Exit Page Builder', $this->text_domain),
                                        'fullScreen'            => __('Full Screen', $this->text_domain),
                                        'exitFullScreen'        => __('Exit Full Screen', $this->text_domain),
                                        'msg'                   => array(
                                                                        'delete'        => __('Are you sure you want to delete it?', $this->text_domain),
                                                                        'enterTitle'    => __('Please enter the title', $this->text_domain),
                                                                        'invalidValue'  => __('Invalid value', $this->text_domain),
                                                                )
                                )
                        );                             
                }
                
                
                
                
                /**
                 * ========================
                 * DISPLAY META BOX CONTENT
                 * ========================
                 */
                                
                /**
                 * Adds widget elements to Modal - Insert Element
                 * @global object $wp_widget_factory
                 * @param string $widget_class
                 */
                protected function display_insert_element__widget($widget_class) {                        
                        $widget_obj     = $GLOBALS['wp_widget_factory']->widgets[$widget_class];
                        $widget_name    = preg_replace('/^\[' . $this->text_domain . '\] /i', '', $widget_obj->name);
?>
                        
                        <div    class           = "element"
                                data-type       = "widget"
                                data-title      = "<?php echo esc_attr($widget_name) ?>"
                                data-args       = '<?php echo json_encode(array(
                                                        "php_class" => $widget_class,
                                                        "css_class" => $widget_obj->widget_options['classname']
                                                )) ?>'
                        >
                                <h5><strong><?php echo esc_html($widget_name) ?></strong></h5>
<?php                           if(!empty($widget_obj->widget_options['description'])) : ?>
                                        <small><?php echo esc_html($widget_obj->widget_options['description']) ?></small>
<?php                           endif; ?>
                        </div><!--.element-->
<?php
                }
                
                /**
                 * Adds custom element to Modal - Insert Element
                 */
                protected function display_insert_element__custom($element) {
                        extract($element);
?>
                        <div    class           = "element"
                                data-type       = "custom"
                                data-title      = "<?php echo esc_attr($title) ?>"
                                data-args       = '<?php echo json_encode(array(
                                                        "php_class" => $php_class,
                                                )) ?>'
                        >
                                <h5><strong><?php echo strip_tags($title) ?></strong></h5>
                                <small><?php echo wp_kses_post($description) ?></small>
                        </div>
<?php
                }
                                
                /**
                 * Tab contents
                 */
                protected function display_insert_element__tab_panes() {
                        $i = 0; 
                        foreach( $this->tabs as $id => $args) : ?>
                                <div class="tab-pane <?php echo $i++ === 0 ? 'active' : '' ?>" id="<?php echo $id ?>">
                                        <div class="row">
<?php                                           foreach($args['items'] as $element) : ?> 
                                                        <div class="col-sm-3">
                                                                <div class="elements">
<?php                                                                   switch ($element['type']) {
                                                                                case 'widget': 
                                                                                        $this->display_insert_element__widget($element['php_class']);                                                                        
                                                                                        break;
                                                                                case 'custom': 
                                                                                        $this->display_insert_element__custom($element);                                                                        
                                                                                        break;
                                                                        } ?>                                
                                                                </div><!--.elements-->
                                                        </div><!--.col-sm-3-->
<?php                                           endforeach; ?>
                                        </div><!--.row-->
<?php                                   
                                        if( isset($args['note']) ) : ?>
                                                <p>
                                                        <small><?php echo $args['note'] ?></small>
                                                </p>
<?php                                   endif; ?>
                                </div><!--.tab-pane-->
<?php                   endforeach;                         
                }
                
                /**
                 * Tab menus
                 */
                protected function display_insert_element__tabs() {                        
                        $i = 0; 
                        foreach( $this->tabs as $id => $args) : ?>
                                <li <?php echo $i++ === 0 ? 'class="active"' : '' ?>>
                                        <a href="#<?php echo $id ?>" data-toggle="tab"><?php echo strip_tags($args['name']) ?></a>
                                </li>
<?php                   endforeach; 
                }

                /**
                 * Render Meta Box content.
                 *
                 * @param WP_Post $post The post object.
                 */
                public function display( $post ) {
                        // Add an nonce field so we can check for it later.
                        wp_nonce_field( 'fsmpb_meta_box', 'fsmpb_meta_box_nonce' );

                        // Use get_post_meta to retrieve an existing value from the database.
                        $data = get_post_meta( $post->ID, 'fsmpb_main', true );                

                        require dirname(__FILE__) . '/template/main.php';
?>
                        <input type="hidden" name="fsmpb_main" value="<?php echo esc_attr($data) ?>">
<?php
                }
                
                
                
                
                /**
                 * ==============
                 * AJAX FUNCTIONS
                 * ==============
                 */
                
                /**
                 * Widget option form
                 */
                public function ajax_widget_form() {        
                        $args           = $_POST['args'];
                        $title          = strip_tags($_POST['title']); 
                        $formData       = isset( $_POST['formData'] ) 
                                        ? stripslashes_deep( $_POST['formData'] ) 
                                        : array();
                        $instance       = new $args['php_class'];
?>       
                        <div class="fsmpb-container fsmh-container">
                                <form id="fsmpb-modal-element-widget-<?php echo $args['php_class'] ?>" class="modal" data-type="element">
                                        <div class="modal-dialog">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                                <h4 class="modal-title"><?php echo $title ?></h4>
                                                        </div>
                                                        <div class="modal-body"><?php $instance->form( $formData ); ?></div>
                                                        <div class="modal-footer">
                                                                <button type="button" class="button" data-dismiss="modal"><?php _e('Close', $this->text_domain) ?></button>
                                                                <button type="submit" class="button button-primary"><?php _e('Insert', $this->text_domain) ?></button>
                                                        </div>
                                                </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                </form><!-- /.modal -->

                                <script>                        
                                        +function($) {                                
                                                $('#fsmpb-modal-element-widget-<?php echo $args['php_class'] ?>').find('[name]').each(function() {
                                                        var     $this   = $(this),
                                                                name    = $this.attr('name').replace(/widget-[\w-]*?\[\]\[([\w]+?)\]([\w\[\]]*)$/, '$1$2'); // removes wp widget prefix

                                                        // Set new name
                                                        $this.attr('name', name); 

                                                        // Sets the value attribute to 1 if it doesn't have any value
                                                        if( (this.type === 'checkbox' || this.type === 'radio') && !$this.is('[value]') ) {
                                                                $this.attr('value', 1);
                                                        }
                                                });
                                        }(jQuery);
                                </script>
                        </div>
<?php   
                        die();
                }
                
                /**
                 * Sanitize widget options
                 */
                public function ajax_widget_form__submit() {            
                        $args           = $_POST['args'];
                        $formData       = isset( $_POST['formData'] ) 
                                        ? $_POST['formData'] 
                                        : array();
                        $instance       = new $args['php_class']; 

                        parse_str($formData, $data);        
                        $data           = stripslashes_deep($data);
                        $clean_data     = $instance->update( $data, array() );

                        // Change string "true" to 1
                        foreach ($clean_data as $key => $value) {
                                if(isset($data[$key]) && $data[$key] == 1 && $value == true) {
                                        $clean_data[$key] = 1;
                                }
                        } 

                        echo json_encode($clean_data);

                        die();
                }            
                                                
                
                
                
                /**
                 * ===============
                 * CUSTOM ELEMENTS
                 * ===============
                 */
                
                /**
                 * Register custom elements
                 * @global $fsmpb_custom_elements
                 */
                protected function register_custom_elements() {
                        global $fsmpb_custom_elements;
                        
                        foreach ($this->custom_element_classes as $php_class) {
                                $fsmpb_custom_elements[$php_class] = new $php_class;
                                
                                // Register ajax functions                        
                                add_action( 'wp_ajax_fsmpb_ajax_custom_form_' . $php_class, array($fsmpb_custom_elements[$php_class], 'form') );
                                add_action( 'wp_ajax_fsmpb_ajax_custom_sanitize_' . $php_class, array($fsmpb_custom_elements[$php_class], 'sanitize') );
                        }
                }
                
                
                
                
                /**
                 * ==========
                 * INITIALIZE
                 * ==========
                 * 
                 * @param array $args
                 */                
                public function __construct( $args = array(
                        'text_domain'           => 'friskamax',
                        'custom_element_classes'=> array()
                ) ) {                        
                        $this->text_domain              = $args['text_domain'];             
                        $this->custom_element_classes   = $args['custom_element_classes'];
                        
                        $this->register_custom_elements();
                                                                        
                        // Register ajax functions
                        add_action( 'wp_ajax_fsmpb_widget_form_ajax', array($this, 'ajax_widget_form') );
                        add_action( 'wp_ajax_fsmpb_widget_form_submit_ajax', array($this, 'ajax_widget_form__submit') );
                        
                        // Register meta box
                        if ( is_admin() ) {
                                add_action( 'load-post.php', array($this, 'register') );
                                add_action( 'load-post-new.php', array($this, 'register') );
                        } 
                }
        }
endif; // Fsmpb_Meta_Box