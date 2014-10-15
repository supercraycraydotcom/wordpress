<?php
/**
 * Hide featured image on singular post page
 * 
 * @package Warta
 */

class Warta_Display_Options_Meta_Box {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
            $post_types = array('post', 'page');     //limit meta box to certain post types
            if ( in_array( $post_type, $post_types )) {
                add_meta_box(
                    'warta_display_options_meta_box'
                    ,__( 'Display options', 'warta' )
                    ,array( $this, 'render_meta_box_content' )
                    ,$post_type
                    ,'side'
                    ,'default'
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
		if ( ! isset( $_POST['warta_display_options_field'] ) )
			return $post_id;

		$nonce = $_POST['warta_display_options_field'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'warta_display_options_action' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$featured       = isset( $_POST['friskamax_hide_featured_image_main'] )
                        ? (int) $_POST['friskamax_hide_featured_image_main']
                        : 0;
		$post_meta_main = isset( $_POST['friskamax_hide_post_meta_main'] )
                        ? (int) $_POST['friskamax_hide_post_meta_main']
                        : 0;

		// Update the meta field.
		update_post_meta( $post_id, 'friskamax_hide_featured_image_main', $featured );
		update_post_meta( $post_id, 'friskamax_hide_post_meta_main', $post_meta_main );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'warta_display_options_action', 'warta_display_options_field' );

		// Use get_post_meta to retrieve an existing value from the database.
		$featured       = get_post_meta( $post->ID, 'friskamax_hide_featured_image_main', true );
		$post_meta_main = get_post_meta( $post->ID, 'friskamax_hide_post_meta_main', true );

		// Display the form, using the current value.
?>
                <p><?php _e('Hide:', 'warta') ?><br>
                    <label>
                        <input type="checkbox" name="friskamax_hide_featured_image_main" value="1" <?php checked($featured, 1) ?>>
                        <?php _e('Featured image on main post page', 'warta') ?>
                    </label><br>
                    <label>
                        <input type="checkbox" name="friskamax_hide_post_meta_main" value="1" <?php checked($post_meta_main, 1) ?>>
                        <?php _e('Post meta on main post page', 'warta') ?>
                    </label>
                </p>
<?php
        }
}