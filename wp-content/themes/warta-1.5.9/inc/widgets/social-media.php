<?php
/**
 * Social Media Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Social_Media')) :
class Warta_Social_Media extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_social_media', // Base ID
                        __('[Warta] Social Media', 'warta'), // Name
                        array( 'description' => __( 'Social media icons.', 'warta' ), ) // Args
                );
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @global array $$friskamax_warta_var Warta theme variables
         * 
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {
                extract( wp_parse_args( $instance, array( 'title' => __( 'New title', 'warta' ) ) ) ); 
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

                        <!--Social media URLs
                        =====================-->
<?php                   foreach ($GLOBALS['friskamax_warta_var']['social_media'] as $key => $value) : ?>
                                <p>
                                        <label><?php printf(_x('%s URL:', 'Social media URL', 'warta'), $value) ?> 
                                                <input class    ="widefat" 
                                                       name     ="<?php echo $this->get_field_name( $key ); ?>" 
                                                       type     ="url" 
                                                       value    ="<?php echo isset( ${$key} ) ? esc_url( ${$key} ) : ''; ?>"
                                                >
                                        </label>
                                </p>
<?php                   endforeach; ?>
                </div>
<?php 
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @global array $friskamax_warta_var Warta theme variables
         * 
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
                $instance = array();
                $instance['title'] = sanitize_text_field( $new_instance['title'] );

                foreach ( array_keys( $GLOBALS['friskamax_warta_var']['social_media'] ) as $key ) {
                        $instance[$key] = esc_url($new_instance[$key]);
                }

                return $instance;
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @global array $friskamax_warta_var Warta theme variables
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
                                echo $args['before_title'] . $title . $args['after_title'];
                        }
?>
                        <ul class="social clearfix"><?php warta_social_media( $instance, 'sc-md'); ?></ul>
                </section>
<?php 
                if(!isset($args['is_pb'])) { 
                        warta_add_clearfix( $args['id'], 6);
                }                
        }

} 
endif; // Warta_Social_Media