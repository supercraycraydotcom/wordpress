<?php
/**
 * Flickr Feed Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Flickr_Feed')) :
class Warta_Flickr_Feed extends WP_Widget {
        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_flickr_feed', // Base ID
                        __('[Warta] Flickr Feed', 'warta'), // Name
                        array( 'description' => __( 'Display latest photos from Flickr', 'warta' ), ) // Args
                );
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {
                extract( wp_parse_args( $instance, array(
                        'title'         => __( 'New title', 'warta' ),
                        'id'            => '',
                        'ids'           => '',
                        'tags'          => '',
                        'tagmode'       => '',
                        'count'         => 8,
                ) ) ); 
?>
                <div>
                        <!--Title
                        ========= -->
                        <p>
                                <label><?php _e('Title:', 'warta') ?> 
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id( 'title' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'title' ); ?>" 
                                               type     ="text" 
                                               value    ="<?php echo esc_attr( $title ); ?>"
                                        >
                                </label>
                        </p>

                        <!--ID
                        ====== -->
                        <p>
                                <label><?php _e('ID:', 'warta') ?> 
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'id' ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>">
                                </label>
                                <small><?php _e('Optional. A single user ID. This specifies a user to fetch for. Example: 112356465@N05. '
                                                . "Note: you can't use your screen name, If you don't know what your ID is, you can get it from "
                                                . "<a href='http://idgettr.com/' target='_blank'>http://idgettr.com/</a>", 'warta') ?>
                                </small>
                        </p>

                        <!--IDs
                        ======= -->
                        <p>
                                <label><?php _e('IDs:', 'warta') ?> 
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'ids' ); ?>" type="text" value="<?php echo esc_attr( $ids ); ?>">
                                </label>
                                <small><?php _e('Optional. A comma delimited list of user IDs without spaces. This specifies a list of users to fetch for. '
                                                . 'Example: 112356465@N05,112356465@N05', 'warta') ?>
                                </small>
                        </p>

                        <!--Tags
                        ======== -->
                        <p>
                                <label><?php _e('Tags:', 'warta') ?> 
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'tags' ); ?>" type="text" value="<?php echo esc_attr( $tags ); ?>">
                                </label>
                                <small><?php _e('Optional. A comma delimited list of tags to filter the feed by. Example: red,green,blue', 'warta') ?></small>
                        </p>

                        <!--Tag mode
                        ============ -->
                        <p>
                                <label><?php _e('Tag mode:', 'warta') ?> 
                                        <select class="widefat" name="<?php echo $this->get_field_name( 'tagmode' ); ?>">
                                                <option value="all" <?php checked($tagmode, 'all') ?>><?php _e('All', 'warta') ?></option>
                                                <option value="any" <?php checked($tagmode, 'any') ?>><?php _e('Any', 'warta') ?></option>
                                        </select>
                                </label>
                                <small><?php _e('Control whether items must have ALL the tags, or ANY of the tags.', 'warta') ?></small>
                        </p>

                        <!--Number of items to show
                        =========================== -->
                        <p>
                                <label><?php _e('Number of items to show:', 'warta') ?> 
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" max="20" value="<?php echo (int) $count; ?>">
                                </label>
                                <small><?php _e('Maximum 20.', 'warta') ?></small>
                        </p>
                </div>
<?php 
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
                $instance               = array();
                $instance['title']      = strip_tags( $new_instance['title'] );
                $instance['id']         = sanitize_text_field( $new_instance['id'] );
                $instance['ids']        = sanitize_text_field( $new_instance['ids'] );
                $instance['tags']       = sanitize_text_field( $new_instance['tags'] );
                $instance['tagmode']    = sanitize_text_field( $new_instance['tagmode'] );
                $instance['count']      = (int) $new_instance['count'];

                return $instance;
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {
                extract($instance);

                $title = apply_filters( 'widget_title', $title );
?>

                <section class="<?php warta_widget_class( $args['id'], 6, TRUE, isset($args['is_pb']) ) ?>">
<?php                   if ( ! empty( $title ) ) {
                                echo $args['before_title'] . strip_tags( $title ) . $args['after_title'];
                        }
?>
                        <ul class       ="flickr-feed clearfix"
                            data-id     ="<?php echo esc_attr($id)  ?>"
                            data-ids    ="<?php echo esc_attr($ids) ?>"
                            data-tags   ="<?php echo esc_attr($tags) ?>"
                            data-tagmode="<?php echo esc_attr($tagmode) ?>"
                            data-count  ="<?php echo esc_attr($count) ?>">
                                <li><i class="fa fa-spinner fa-spin"></i> <?php echo esc_attr_e('Please wait&hellip;', 'warta') ?></li>
                                <li>
                                        <script type="text/template">
                                                <li>
                                                        <a href="{{link}}" target="_blank" title="{{title}}" class="<?php echo warta_is_footer( $args['id'] ) ? 'dark' : 'light'; ?>">
                                                                <img src="{{thumbnail}}" alt="{{title}}">
                                                                <div class="layer"></div>
                                                        </a>
                                                </li>
                                        </script>
                                </li>
                        </ul>
                </section>
<?php           
                if( !isset($args['is_pb']) ) { 
                        warta_add_clearfix( $args['id'], 6);
                }
        }

} 
endif; // Warta_Flickr_Feed