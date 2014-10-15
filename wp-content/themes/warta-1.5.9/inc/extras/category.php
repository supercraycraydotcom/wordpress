<?php

//add extra fields to category edit form callback function
if(!function_exists('warta_extra_category_fields')) :
        function warta_extra_category_fields( $tag ) {    
                //check for existing featured ID
                $term_id        = $tag->term_id;
                $cat_meta       = get_option( "warta_cat_meta_$term_id");
                
                extract($cat_meta);
                $page_title_bg  = isset($page_title_bg) && !!$page_title_bg 
                                ? $page_title_bg
                                : '';

                wp_enqueue_media();
        ?>
                <tr class="form-field">
                        <th scope="row" valign="top"><label for="cat_Image_url"><?php _e('Custom Title Background'); ?></label></th>
                        <td>
                                <div id="warta_page_title_bg_holder">
<?php                                   if( !!$page_title_bg ) {
                                                echo wp_get_attachment_image( $cat_meta['page_title_bg'], 'medium' );
                                        } ?>
                                </div>
                                <a class="button" id="warta_page_title_bg_upload" href="#"><?php _e('Upload', 'warta') ?></a>
                                <a class="button <?php if( !$page_title_bg ) echo 'hidden' ?>" id="warta_page_title_bg_remove" href="#"><?php _e('Remove', 'warta') ?></a>

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
                                                                                                                                                
                                                                        if (!!attachment.id) {
                                                                                var imgUrl = !!attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

                                                                                $("#warta_page_title_bg").val( attachment.id );

                                                                                var newImage = $("<img>").attr( {
                                                                                        src: imgUrl
                                                                                } );

                                                                                $("#warta_page_title_bg_holder").empty().append(newImage);
                                                                                $('#warta_page_title_bg_remove').removeClass('hidden').show();
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

                                <input type="hidden" name="warta_cat_meta[page_title_bg]" id="warta_page_title_bg" value="<?php echo !!$page_title_bg ? $page_title_bg : ''; ?>">
                        </td>
                </tr>
        <?php
        }
endif;
//add extra fields to category edit form hook
add_action ( 'edit_category_form_fields', 'warta_extra_category_fields');

// save extra category extra fields callback function
if(!function_exists('warta_save_extra_category_fileds')) :
        function warta_save_extra_category_fileds( $term_id ) {
                if ( isset( $_POST['warta_cat_meta'] ) ) {
                        $cat_meta       = get_option( "warta_cat_meta_$term_id");

                        foreach ($_POST['warta_cat_meta'] as $key => $value){
                                $cat_meta[$key] = sanitize_text_field( $_POST['warta_cat_meta'][$key] );
                        }

                        //save the option array
                        update_option( "warta_cat_meta_$term_id", $cat_meta );
                }
        }
endif;
// save extra category extra fields hook
add_action ( 'edited_category', 'warta_save_extra_category_fileds');