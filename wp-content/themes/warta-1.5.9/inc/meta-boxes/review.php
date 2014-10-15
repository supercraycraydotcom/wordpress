<?php
/**
 * Custom Sidebar Meta Box
 * 
 * @package Warta
 */

if( !function_exists('warta_review_cookie')) :
/**
 * Set cookie values for user rating
 */
function warta_review_cookie() {
        if( isset( $_SESSION['friskamax_review_user_rating'] ) ) {
                foreach ($_SESSION['friskamax_review_user_rating'] as $key => $value) { 
                        $key    = (int) $key;
                        $value  = (float) $value;

                        if ( !isset( $_COOKIE["friskamax_review_user_rating[{$key}]"] ) ) {
                            setcookie( "friskamax_review_user_rating[{$key}]", $value, time() + (365 * 24 * 60 * 60) );
                        }
                }
        }    
}
endif; // warta_review_cookie
add_action('init','warta_review_cookie');



/**
 * Review Meta Box Class
 */
class Warta_Review_Meta_Box {
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
                $post_types = array('post');     //limit meta box to certain post types
                if ( in_array( $post_type, $post_types )) {
                        add_meta_box(
                                'warta_review_meta_box'
                                ,__( 'Review Box', 'warta' )
                                ,array( $this, 'render_meta_box_content' )
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
            if ( ! filter_input( INPUT_POST, 'warta_review_field' ) ) {
                        return $post_id;
                    }

            $nonce = filter_input( INPUT_POST, 'warta_review_field' );

            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce( $nonce, 'warta_review_action' ) ) {
                        return $post_id;
                    }

            // If this is an autosave, our form has not been submitted,
                    //     so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                        return $post_id;
                    }

            // Check the user's permissions.
            if ( 'page' == filter_input(INPUT_POST, 'post_type') ) {
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
            $titles         = (array) $_POST['warta_review_titles'];
            $scores         = (array) $_POST['warta_review_scores'];
            $total          = (float) $_POST['warta_review_total'];
            $total          = $total ? $total : 0.0;
            $total          = $total > 5 ? 5.0 : $total;
            $summary        = wp_kses_post( $_POST['warta_review_summary'] );

            $advanced               = isset( $_POST['warta_review_advanced'] ) ? (int) $_POST['warta_review_advanced'] : 0;   
            $title                  = sanitize_text_field( $_POST['warta_review_title'] );   
            $type                   = sanitize_text_field( $_POST['warta_review_type'] );   
            $position               = sanitize_text_field( $_POST['warta_review_position'] );   
            $score_text             = sanitize_text_field( $_POST['warta_review_score_text'] );   
            $enable_categories      = isset( $_POST['warta_review_enable_categories'] )
                                    ? (int) $_POST['warta_review_enable_categories'] 
                                    : 0;
            $enable_user_rating     = isset( $_POST['warta_review_enable_user_rating'] )
                                    ? (int) $_POST['warta_review_enable_user_rating'] 
                                    : 0;

            foreach ( $scores as $key => $value) {
                    $value = $value ? $value : 0.0;
                    $value = $value > 5 ? 5.0 : $value;

                    $scores[$key] = (float) $value;

                    $titles[$key] ? sanitize_text_field( $titles[$key] ) : __('New Title', 'warta');
            }                

            // Update the meta field.
            update_post_meta( $post_id, 'friskamax_review_titles', $titles );
            update_post_meta( $post_id, 'friskamax_review_scores', $scores );
            update_post_meta( $post_id, 'friskamax_review_total', $total );
            update_post_meta( $post_id, 'friskamax_review_summary', $summary );

            update_post_meta( $post_id, 'friskamax_review_advanced', $advanced );
            update_post_meta( $post_id, 'friskamax_review_title', $title );
            update_post_meta( $post_id, 'friskamax_review_type', $type );
            update_post_meta( $post_id, 'friskamax_review_position', $position );
            update_post_meta( $post_id, 'friskamax_review_score_text', $score_text );
            update_post_meta( $post_id, 'friskamax_review_enable_categories', $enable_categories );
            update_post_meta( $post_id, 'friskamax_review_enable_user_rating', $enable_user_rating );
        }


        /**
         * Render Meta Box content.
         *
         * @param WP_Post $post The post object.
         */
        public function render_meta_box_content( $post ) {
                global $friskamax_warta;        
                $friskamax_warta = wp_parse_args( $friskamax_warta, array(
                        'review_box_enable_categories'  => 1,
                        'review_box_enable_user_rating' => 1
                ) );

                // Add an nonce field so we can check for it later.
                wp_nonce_field( 'warta_review_action', 'warta_review_field' );

                // Use get_post_meta to retrieve an existing value from the database.
                $titles         = get_post_meta( $post->ID, 'friskamax_review_titles', true );
                $scores         = get_post_meta( $post->ID, 'friskamax_review_scores', true );
                $total          = get_post_meta( $post->ID, 'friskamax_review_total', true );
                $summary        = get_post_meta( $post->ID, 'friskamax_review_summary', true );

                $titles         = is_array( $titles ) ? $titles : array( __('New Title ', 'warta') );
                $scores         = is_array( $scores ) ? $scores : array( 0 );    

                // Advanced options
                $advanced               = get_post_meta( $post->ID, 'friskamax_review_advanced', true );
                $title                  = get_post_meta( $post->ID, 'friskamax_review_title', true );
                $type                   = get_post_meta( $post->ID, 'friskamax_review_type', true );
                $position               = get_post_meta( $post->ID, 'friskamax_review_position', true );
                $score_text             = get_post_meta( $post->ID, 'friskamax_review_score_text', true );
                $enable_categories      = get_post_meta( $post->ID, 'friskamax_review_enable_categories', true );
                $enable_user_rating     = get_post_meta( $post->ID, 'friskamax_review_enable_user_rating', true );

                // Get default values for advanced options
                $title                  = !!$title                      ? $title                : $friskamax_warta['review_box_title'];
                $type                   = !!$type                       ? $type                 : $friskamax_warta['review_box_score_type'];
                $position               = !!$position                   ? $position             : $friskamax_warta['review_box_position'];
                $score_text             = !!$score_text                 ? $score_text           : '';
                $enable_categories      = $enable_categories != ''      ? $enable_categories    : $friskamax_warta['review_box_enable_categories'];
                $enable_user_rating     = $enable_user_rating != ''     ? $enable_user_rating   : $friskamax_warta['review_box_enable_user_rating'];

                // Display the form, using the current value. ?>
                <div class="fsmh-container">

                        <div data-requires='[{"field":"#warta_review_enable_categories", "compare":"check"}]'>
                                <!--Review Categories
                                ===================== -->
<?php                           foreach ( $titles as $key => $value ) : ?>
                                        <div class="fsmh-tab"> 
                                                <label>
                                                        <?php _e('Category Title:', 'warta') ?>
                                                        <input type="text" name="warta_review_titles[]" value="<?php echo esc_attr( $value ) ?>">
                                                </label> &nbsp;
                                                <label>
                                                        <?php _e('Category Score:', 'warta') ?>
                                                        <input type="number" min="0" max="5" step="0.1" name="warta_review_scores[]" value="<?php echo (float) $scores[$key] ?>">
                                                </label> &nbsp;

                                                <!--Remove category-->
                                                <button type="button" class="fsmh-tab-remove button button-small"><?php _e('Remove category', 'warta') ?></button>
                                        </div>
<?php                           endforeach;  ?>

                                <!--Add Category-->
                                <p class="fsmh-tab-add"><button type="button" class="button button-small">Add Category</button></p>                    
                                <hr>
                    </div>

                    <!--Total Score
                    =============== -->
                    <p>
                            <label><?php _e('Total Score: ', 'warta') ?> 
                                    <input type="text" name="warta_review_total" class="review-total-score" value="<?php echo $total ? (float) $total : 0.0 ?>">
                            </label> 
                    </p>
                    <hr>

                    <!--Summary
                    =========== -->
                    <p>
                            <label><?php _e('Summary: ', 'warta') ?>
                                    <textarea name="warta_review_summary" class="widefat" rows="4"><?php echo wp_kses_post( $summary ) ?></textarea>
                            </label>
                    </p>
                    <hr>

                    <!--Advanced
                    ============-->
                    <p>
                            <label>
                                    <input type="checkbox" name="warta_review_advanced" value="1" <?php checked($advanced, 1) ?> id="warta_review_advanced">
                                    <?php _e('Enable advanced options', 'warta') ?>
                            </label>
                    </p>
                    <div data-requires='[{"field":"#warta_review_advanced", "compare":"check"}]'>
                            <table>
                                    <tr>
                                            <td><label for="warta_review_title"><?php _e('Title', 'warta') ?></label></td>
                                            <td><input type="text" name='warta_review_title' value="<?php echo esc_attr( $title ) ?>" id="warta_review_title" class="widefat"></td>
                                    </tr>
                                    <tr>
                                            <td><label for="warta_review_type"><?php _e('Score Type', 'warta') ?></label></td>
                                            <td>
                                                    <select name="warta_review_type" id="warta_review_type" class="widefat">
                                                                <option value="bar"             <?php selected($type, 'bar') ?>>            <?php _ex('Bar', 'Review score type', 'warta') ?>                </option>
                                                                <option value="bar_animated"    <?php selected($type, 'bar_animated') ?>>   <?php _ex('Bar animated', 'Review score type', 'warta') ?>       </option>
                                                                <option value="star"            <?php selected($type, 'star') ?>>           <?php _ex('Star', 'Review score type', 'warta') ?>               </option>
                                                    </select>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td><label for="warta_review_position"><?php _e('Position', 'warta') ?></label></td>
                                            <td>
                                                        <select name="warta_review_position" id="warta_review_position" class="widefat">
                                                                <option value="top"         <?php selected($position, 'top') ?>>    <?php _e('Top', 'warta') ?>     </option>
                                                                <option value="bottom"      <?php selected($position, 'bottom') ?>> <?php _e('Bottom', 'warta') ?>  </option>
                                                        </select>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td><label for="warta_review_score_text"><?php _e('Score Text', 'warta') ?></label></td>
                                            <td><input type="text" name="warta_review_score_text" value="<?php echo $score_text ?>" id="warta_review_score_text" 
                                                       data-score-text="<?php echo esc_attr( $friskamax_warta['review_box_score_text'] ) ?>"></td>
                                    </tr>
                                    <tr>
                                            <td colspan="2">
                                                    <label>
                                                            <input type="checkbox" name="warta_review_enable_categories" value="1" <?php checked( $enable_categories, 1 ) ?> id='warta_review_enable_categories'>
                                                            <?php _e('Enable score categories', 'warta') ?>
                                                    </label><br>
                                                    <label>
                                                            <input type="checkbox" name="warta_review_enable_user_rating" value="1" <?php checked( $enable_user_rating, 1 ) ?>>
                                                            <?php _e('Enable user rating', 'warta') ?>
                                                    </label>
                                            </td>
                                    </tr>
                            </table>     
                    </div>

            </div><!--wrapper-->
    <?php
        }
}