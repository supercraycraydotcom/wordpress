<?php
/**
 * Warta Feedburner Widget initialization
 *
 * @package Warta
 */

if(!class_exists('Warta_Feedburner')) :
class Warta_Feedburner extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_feedburner', // Base ID
                        __('[Warta] Feedburner', 'warta'), // Name
                        array( 'description' => __( 'Feedburner email subscription.', 'warta' ), ) // Args
                );
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
                <section class="<?php warta_widget_class( $args['id'], 6, TRUE, isset($args['is_pb']) ) ?> feedburner">
<?php                   if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title']; ?>

                        <form action="http://feedburner.google.com/fb/a/mailverify" 
                                method="post" 
                                target="popupwindow" 
                                onsubmit="window.open(
                                        'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( $feedburner_id ) ?>', 
                                        'popupwindow', 
                                        'scrollbars=yes,width=550,height=520'
                        );return true">
                                <div class="input-group">
                                        <i class="fa fa-envelope"></i>
                                        <input type="email" name="email" class="input-light" placeholder="<?php _e('Enter your email address', 'warta') ?>" />                                        
                                </div>
                                <input type="hidden" value="<?php echo esc_attr( $feedburner_id ) ?>" name="uri"/>
                                <input type="hidden" name="loc" value="en_US"/>
                                <input type="submit" class="btn btn-primary" value="<?php _e('Subscribe', 'warta') ?>" />   
                        </form>
                </section>

<?php           if( !isset($args['is_pb']) ) {
                        warta_add_clearfix( $args['id'], 6);
                }
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
                                'feedburner_id' => ''
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

                        <!--Feedburner ID
                        =================-->
                        <p>
                                <label><?php _e('Feedburner ID:', 'warta') ?>
                                            <input class="widefat" name="<?php echo $this->get_field_name('feedburner_id') ?>" value="<?php echo esc_attr( $feedburner_id ) ?>">
                                </label>
                                <small><?php _e('Example: If your Feedburner URL is http://feeds.feedburner.com/YourFeedburnerID, then <strong>YourFeedburnerID</strong> is your ID', 'warta') ?></small>
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
                $instance = array();
                $instance['title']          = sanitize_text_field( $new_instance['title'] );
                $instance['feedburner_id']  = sanitize_text_field( $new_instance['feedburner_id'] );

                return $instance;
        }

} 
endif; // Warta_Feedburner