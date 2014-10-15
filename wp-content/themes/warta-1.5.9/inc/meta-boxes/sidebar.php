<?php

/** 
 * The Class.
 */
class Warta_Sidebar_Meta_Box {
        
        /**
         * Render Meta Box content.
         *
         * @param WP_Post $post The post object.
         */
        public function render_meta_box_content( $post ) {
                // Add an nonce field so we can check for it later.
                wp_nonce_field( 'warta_sidebar_meta_box_action', 'warta_sidebar_meta_box_nonce' );

                $old_sidebar            = get_post_meta( $post->ID, 'friskamax_sidebar', true );
                $fsmpb_widget_areas     = get_option('fsmpb_widget_areas', array());

?>
                <div id="warta-sidebar-meta-box-container" class="fsmh-container"> 
                        <p>
                                <label><?php esc_attr_e('Widget area', 'warta') ?>
                                        <select name="warta_sidebar_widget_area" class="widefat"> 
                                                <option></option>
<?php                                           foreach ($GLOBALS['wp_registered_sidebars'] as $widget_area) : ?>
                                                        <option value="<?php echo $widget_area['id'] ?>" <?php selected($old_sidebar, $widget_area['id']) ?>>
<?php                                                           echo $widget_area['name'] ?>
                                                        </option>
<?php                                           endforeach ?>                                                                         
                                                <option value="add_new"><?php _e('Add new', 'warta') ?></option>
                                        </select>
                                </label>
                        </p>
                        <p data-requires='<?php
                                $requires = array();
                                foreach (array_keys($fsmpb_widget_areas) as $value) {
                                        $requires[] = array(
                                                'field'         => '[name=warta_sidebar_widget_area]',
                                                'compare'       => 'equal',
                                                'value'         => $value
                                        );
                                }
                                echo json_encode($requires); 
                        ?>'>
                                <button data-delete type="button" class="button"><?php _e('Delete', 'warta') ?></button>
                        </p>
                        <div data-requires='[{"field":"[name=warta_sidebar_widget_area]", "compare":"equal", "value":"add_new"}]'>
                                <p>
                                        <label><?php _e('Name', 'warta') ?>
                                                <input type="text" name="warta_sidebar_new_name" class="widefat">
                                        </label>
                                </p>
                                <p>
                                        <label><?php _e('Description', 'warta') ?>
                                                <input type="text" name="warta_sidebar_new_description" class="widefat">
                                        </label>
                                </p>
                        </div>
                </div>

                <script>
                        +function($) { 'use strict';
                                var     $container      = $('#warta-sidebar-meta-box-container'),
                                        $widgetArea     = $container.find('[name=warta_sidebar_widget_area]');

                                $container.find('[data-delete]').click(function() {
                                        if(confirm('<?php esc_attr_e('Are you sure want to delete this widget area?', 'warta') ?>')) {
                                                var widgetAreaId = $widgetArea.val();          

                                                $widgetArea.find('option[value="' + widgetAreaId + '"]').remove();
                                                $widgetArea.trigger('change');
                                                $container.append( $('<input>', {
                                                        type    : 'hidden',
                                                        name    : 'warta_sidebar_delete[' + widgetAreaId + ']',
                                                } ) );
                                        }
                                });                   
                        }(jQuery);
                </script>
<?php
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
                if ( ! isset( $_POST['warta_sidebar_meta_box_nonce'] ) ) {
                        return $post_id;
                }

                $nonce = $_POST['warta_sidebar_meta_box_nonce'];

                // Verify that the nonce is valid.
                if ( ! wp_verify_nonce( $nonce, 'warta_sidebar_meta_box_action' ) ) {
                        return $post_id;
                }

                // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { 
                        return $post_id;
                }

                // Check the user's permissions.
                if ( 'page' == $_POST['post_type'] ) {
                        if ( ! current_user_can( 'edit_page', $post_id ) ) {
                                return $post_id;
                        }
                } else {
                        if ( ! current_user_can( 'edit_post', $post_id ) ) {
                                return $post_id;
                        }
                }

                /* OK, its safe for us to save the data now. */

                // Sanitize the user input.                                        
                $db_widget_areas        = get_option('fsmpb_widget_areas', array());
                $new_widget_area        = sanitize_text_field( $_POST['warta_sidebar_widget_area'] );

                if($new_widget_area == 'add_new') {
                        $new_widget_area        = 'fsmpb-' . strtolower( sanitize_html_class( $_POST['warta_sidebar_new_name'] ) );
                        $new_name               = sanitize_text_field( $_POST['warta_sidebar_new_name'] ); 
                        $new_description        = sanitize_text_field( $_POST['warta_sidebar_new_description'] );                                

                        $db_widget_areas[$new_widget_area]      = array(
                                                                        'id'            => $new_widget_area,
                                                                        'name'          => $new_name,
                                                                        'description'   => $new_description,
                                                                        'type'          => 'main'
                                                                ); 
                        update_option('fsmpb_widget_areas', $db_widget_areas);
                } 

                if( isset($_POST['warta_sidebar_delete']) ) {
                        foreach (array_keys($_POST['warta_sidebar_delete']) as $key) {
                                if(isset($db_widget_areas[$key])) {
                                        unset($db_widget_areas[$key]);
                                }
                        }
                        update_option('fsmpb_widget_areas', $db_widget_areas);
                }

                // Update the meta field.
                update_post_meta( $post_id, 'friskamax_sidebar', $new_widget_area );
        }

        /**
         * Adds the meta box container.
         */
        public function add_meta_box( $post_type ) {
                $post_types = array('post', 'page');     //limit meta box to certain post types
                if ( in_array( $post_type, $post_types )) {
                        add_meta_box(
                            'warta_sidebar_meta_box'
                            ,__( 'Custom Sidebar', 'warta' )
                            ,array( $this, 'render_meta_box_content' )
                            ,$post_type
                            ,'side'
                            ,'default'
                        );
                }
        }

        


        /**
         * Hook into the appropriate actions when the class is constructed.
         */
        public function __construct() {                                        
                add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
                add_action( 'save_post', array( $this, 'save' ) );
        }

        
}