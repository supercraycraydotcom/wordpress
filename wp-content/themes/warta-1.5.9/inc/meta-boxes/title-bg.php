<?php
/**
 * Custom page title bg
 * 
 * @package Warta
 */

class Warta_Page_Title_BG_Meta_Box {

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
                    'warta_page_title_bg_meta_box'
                    ,__( 'Custom Title Background', 'warta' )
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
		if ( ! isset( $_POST['warta_page_title_bg_field'] ) )
			return $post_id;

		$nonce = $_POST['warta_page_title_bg_field'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'warta_page_title_bg_action' ) )
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
        $option         = sanitize_text_field( $_POST['warta_page_title_op'] );
		$image_id       = (int) $_POST['warta_page_title_bg'];
                
		// Update the meta field.
		update_post_meta( $post_id, 'friskamax_page_title_bg', $image_id );
		update_post_meta( $post_id, 'friskamax_page_title_op', $option );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) { 
                wp_enqueue_media();  // we need this for WordPress Uploader frame
	
                // Add an nonce field so we can check for it later.
                wp_nonce_field( 'warta_page_title_bg_action', 'warta_page_title_bg_field' );

                // Use get_post_meta to retrieve an existing value from the database.
                $image_id       = get_post_meta( $post->ID, 'friskamax_page_title_bg', true );
                $option         = get_post_meta( $post->ID, 'friskamax_page_title_op', true );
                $option         = !!$option ? $option : 'upload';

                // Display the form, using the current value. 
?>
                <div class="fsmh-container">
                        <style>
                                #warta_page_title_bg_holder img { max-width: 100%; }
                                #warta_page_title_bg_holder     { margin: 10px 0}
                        </style>

                        <select id="warta_page_title_op" name="warta_page_title_op" class="widefat">
                                <option value="upload"          <?php selected($option, 'upload') ?>>   <?php _e('Upload new image', 'warta') ?>        </option>
                                <option value="featured"        <?php selected($option, 'featured') ?>> <?php _e('Use featuted image', 'warta') ?>      </option>
                        </select>
                
                        <div data-requires='[{"field":"#warta_page_title_op", "compare":"equal", "value":"upload"}]'>
                                <div id="warta_page_title_bg_holder">
<?php                                   if( $image_id ) {
                                                echo wp_get_attachment_image( $image_id, 'medium' );
                                        } ?>
                                </div><!--Image holder-->

                                <input id="warta_page_title_bg" name="warta_page_title_bg" type="hidden" value="<?php echo $image_id ?>" />
                                <a class="button" id="warta_page_title_bg_upload" href="#"><?php _e('Upload', 'warta') ?></a>
                                <a class="button right <?php if( !$image_id ) echo 'hidden' ?>" id="warta_page_title_bg_remove" href="#"><?php _e('Remove', 'warta') ?></a>
                        </div>
                                
                        <script>
                        jQuery(document).ready(function ($)
                        {
                                $("#warta_page_title_bg_upload").click(function (event) {
                                        var UploadFrame = false;

                                        event.preventDefault();

                                        if (UploadFrame) {
                                                UploadFrame.open();
                                                return;
                                        }

                                        UploadFrame = wp.media.frames.my_upload_frame = wp.media( {
                                                frame: "select",
                                                title: "<?php _e('Custom Title Background', 'warta') ?>",
                                                library: {
                                                        type: "image"
                                                },
                                                button: {
                                                        text: "<?php _e('Set as Title Background', 'warta') ?>"
                                                },
                                                multiple: false
                                        });

                                        UploadFrame.on("select", function () {
                                                var selection = UploadFrame.state().get("selection");

                                                selection.map( function (attachment) {
                                                        attachment = attachment.toJSON();
                                                        if (attachment.id)
                                                        {
                                                                var logoMediumImageSize = !!attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

                                                                $("#warta_page_title_bg").val( attachment.id );

                                                                var newLogoImage = $("<img>").attr( {
                                                                        src: logoMediumImageSize
                                                                } );

                                                                $("#warta_page_title_bg_holder").empty().append(newLogoImage);

                                                                $('#warta_page_title_bg_remove').show();
                                                        }
                                                });
                                        });

                                        UploadFrame.open();
                                });

                                $('#warta_page_title_bg_remove').click( function(event) {
                                        $('#warta_page_title_bg').val('');
                                        $("#warta_page_title_bg_holder").empty();
                                        $(this).hide();

                                        event.preventDefault();
                                });
                        });
                        </script>
                </div><!--wrapper-->
<?php
        }
}