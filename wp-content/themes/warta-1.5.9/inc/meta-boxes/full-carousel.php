<?php

class Warta_Full_Width_Carousel_Meta_Box extends Warta_Posts_Carousel {

        /**
         * Hook into the appropriate actions when the class is constructed.
         */
        public function __construct() {
                parent::__construct();
                add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
                add_action( 'save_post', array( $this, 'save' ) );
        }

        /**
         * Adds the meta box container.
         */
        public function add_meta_box( $post_type ) {
                if ($post_type == 'page') {
                        add_meta_box(
                                'warta_full_width_carousel_meta_box'
                                ,__( 'Full Width Carousel', 'warta' )
                                ,array( $this, 'render_meta_box_content' )
                                ,$post_type
                                ,'side'
                        );
                }
        }
        
        /**
         * Constructs name attributes for use in form() fields
         *
         * This function should be used in form() methods to create name attributes for fields to be saved by update()
         *
         * @param string $field_name Field name
         * @return string Name attribute for $field_name
         */
        function get_field_name($field_name) {
                return "warta_full_width_carousel[$field_name]";
        }


        /**
         * Render Meta Box content.
         *
         * @param WP_Post $post The post object.
         */
        public function render_meta_box_content( $post ) {
                // Add an nonce field so we can check for it later.
                wp_nonce_field( 'warta_full_width_carousel_meta_box_action', 'warta_full_width_carousel_meta_box_nonce' );

                // Use get_post_meta to retrieve an existing value from the database.
                $enable         = get_post_meta( $post->ID, 'warta_full_width_carousel_enable', TRUE);
                $options        = get_post_meta( $post->ID, 'warta_full_width_carousel_options', true );

                // Display the form, using the current value.
?>
                <div class="fsmh-container">
                        <p>
                                <label>
                                        <input type="checkbox" id="warta_full_width_carousel_enable" name="warta_full_width_carousel_enable" value="1" <?php checked($enable, 1) ?>>
<?php                                   _e('Enable full width carousel', 'warta'); ?>
                                </label>
                        </p>
                        <div data-requires='[{"field":"#warta_full_width_carousel_enable", "compare":"check"}]'>
<?php                           $this->form($options, TRUE); ?>
                        </div>
                </div>
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
                if ( ! isset( $_POST['warta_full_width_carousel_meta_box_nonce'] ) ) {
                        return $post_id;
                }

                $nonce = $_POST['warta_full_width_carousel_meta_box_nonce'];

                // Verify that the nonce is valid.
                if ( ! wp_verify_nonce( $nonce, 'warta_full_width_carousel_meta_box_action' ) ) {
                    return $post_id;
                }

                // If this is an autosave, our form has not been submitted,
                // so we don't want to do anything.
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                        return $post_id;
                }

                // Check the user's permissions.
                if ( !current_user_can( 'edit_page', $post_id ) ) {
                        return $post_id;
                }


                /* OK, its safe for us to save the data now. */
                
                // Sanitize the user input
                $enable         = isset($_POST['warta_full_width_carousel_enable']) ? 1 : 0;
                $options        = $this->update($_POST['warta_full_width_carousel']);
                
                // Update the meta field.
                update_post_meta( $post_id, 'warta_full_width_carousel_enable', $enable );
                update_post_meta( $post_id, 'warta_full_width_carousel_options', $options );
        }
}