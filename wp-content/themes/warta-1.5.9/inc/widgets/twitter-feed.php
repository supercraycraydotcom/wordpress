<?php
/**
 * Twitter Feed Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Twitter_Feed')) :
class Warta_Twitter_Feed extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_twitter_feed', // Base ID
                        __('[Warta] Twitter Feed', 'warta'), // Name
                        array( 'description' => __( 'Display latest tweets', 'warta' ), ) // Args
                );  
        }
        
        /**
         * Get default option values
         * 
         * @param boolean $is_update Is it for $this->update()
         * @return array
         */
        protected function get_default_form_data($is_update = FALSE) {
                return array(
                        'title'         => __( 'New title', 'warta' ),
                        'appearance'    => 'avatar',
                        'display_date'  => $is_update ? 0 : 1,
                        'display_reply' => $is_update ? 0 : 1,
                        'username'      => '',
                        'count'         => 4,
                        'date_format'   => '%B %d, %Y',
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
                extract( wp_parse_args( $instance, $this->get_default_form_data() ) ); 
?>
                <div>
                        <!--Title
                        =========-->
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

                        <!--Appearance
                        ============== -->
                        <p><?php _e('Appearance:', 'warta') ?>
                                <select name="<?php echo $this->get_field_name( 'appearance' ); ?>" class="widefat">
                                        <option value="avatar"  <?php selected($appearance, 'avatar') ?>>    <?php _e('Avatar', 'warta') ?>          </option>
                                        <option value="icon"    <?php selected($appearance, 'icon') ?>>      <?php _e('Icon', 'warta') ?>            </option>
                                        <option value="text"    <?php selected($appearance, 'text') ?>>      <?php _e('Text Only', 'warta') ?>       </option>
                                </select>
                                <label>
                                        <input id       ="<?php echo $this->get_field_id( 'display_date' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'display_date' ); ?>" 
                                               type     ="checkbox" 
                                               value    ="1" 
                                               <?php checked( $display_date, 1 ) ?>
                                        >
<?php                                   _e('Display date', 'warta') ?> 
                                </label><br>
                                <label>
                                        <input id       ="<?php echo $this->get_field_id( 'display_reply' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'display_reply' ); ?>" 
                                               type     ="checkbox" 
                                               value    ="1" 
                                               <?php checked( $display_reply, 1 ) ?>
                                        >
<?php                                   _e('Display reply link', 'warta') ?> 
                                </label>
                        </p>

                        <!--Username
                        ============ -->
                        <p>
                                <label><?php _e('Username:', 'warta') ?> 
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id( 'username' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'username' ); ?>" 
                                               type     ="text" 
                                               value    ="<?php echo esc_attr( $username ); ?>"
                                        >
                                </label>
                                <small><?php _e('Optional to load tweets from another account.', 'warta') ?></small>
                        </p>

                        <!--Number of items to show
                        =========================== -->
                        <p>
                                <label><?php _e('Number of items to show:', 'warta') ?> 
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" value="<?php echo (int) $count; ?>">
                                </label>
                        </p>

                        <!--Date format
                        =============== -->
                        <p>
                                <label><?php _e('Date format:', 'warta') ?> 
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id( 'date_format' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'date_format' ); ?>" 
                                               type     ="text" 
                                               value    ="<?php echo esc_attr( $date_format ); ?>"
                                        >
                                </label>
                                <span style="display: block; height: 5px;"></span>
                                <small>
                                        <code>%d</code>: <?php _ex('Date, 1, 2, 3 ...', 'Twitter date format', 'warta') ?><br>
                                        <code>%m</code>: <?php _ex('Month number 1, 2, 3 ...', 'Twitter date format', 'warta') ?><br>
                                        <code>%b</code>: <?php _ex('Abbreviated month Jan, Feb, Mar ...', 'Twitter date format', 'warta') ?><br>
                                        <code>%B</code>: <?php _ex('Full month January, February, March ...', 'Twitter date format', 'warta') ?><br>
                                        <code>%y</code>: <?php _ex('Last two digits of year, 12, 13, 14 ...', 'Twitter date format', 'warta') ?><br>
                                        <code>%Y</code>: <?php _ex('Full year 2012, 2013, 2014 ...', 'Twitter date format', 'warta') ?>
                                </small>
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
                $new_instance                   = wp_parse_args($new_instance, $this->get_default_form_data(TRUE));
                $instance                       = array();
                $instance['title']              = sanitize_text_field( $new_instance['title'] );
                $instance['appearance']         = sanitize_text_field( $new_instance['appearance'] );
                $instance['display_date']       = sanitize_text_field( $new_instance['display_date'] );
                $instance['display_reply']      = sanitize_text_field( $new_instance['display_reply'] );
                $instance['username']           = sanitize_text_field( $new_instance['username'] );
                $instance['count']              = (int) $new_instance['count'];
                $instance['date_format']        = sanitize_text_field( $new_instance['date_format'] );

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
                extract( wp_parse_args($instance, $this->get_default_form_data()) );
                
                $title = apply_filters( 'widget_title', $title );                
?>                
                <section class="<?php warta_widget_class( $args['id'], 6, TRUE, isset($args['is_pb']) ) ?>">                    
<?php                   if ( ! empty( $title ) ) { 
                                echo $args['before_title'] . strip_tags( $title ) . $args['after_title'];
                        }
?>                    
                        <div class              ="twitter-feed" 
                             data-username      ='<?php echo esc_attr($username) ?>'
                             data-count         ='<?php echo (int) $count ?>'
                             data-date-format   ='<?php echo esc_attr($date_format) ?>'
                             data-loading-text  ='<span><i class="fa fa-spinner fa-spin"></i> <?php echo esc_attr_e('Please wait&hellip;', 'warta') ?></span>'
                        >                        
                                <script type="text/template">                            
<?php                                   if($appearance != 'text') : ?>
                                                <div class="avatar">
<?php                                                   echo $appearance == 'avatar' ? '{{avatar}}' : '<i class="fa fa-twitter"></i>'; ?>
                                                </div>
<?php                                   endif; ?>                                     
                                        <div class="content">
                                                {{tweet}}                         
<?php                                           if( !!$display_date || !!$display_reply ) : ?>
                                                        <p class="post-meta">                                                
<?php                                                           if($display_date) : ?>
                                                                        <a href="{{url}}" target="_blank"><i class="fa fa-clock-o"></i> {{date}}</a> &nbsp;
<?php                                                           endif;                 
                                                                if(!!$display_reply) : ?>
                                                                        <a href="{{url}}" target="_blank"><i class="fa fa-reply"></i> Reply</a>
<?php                                                           endif ?>    
                                                        </p>                            
<?php                                           endif; ?>
                                        </div>
                                </script>                        
                        </div>
                        <div class="clearfix"></div>
                </section>
<?php           
                if(!isset($args['is_pb'])) {
                        warta_add_clearfix( $args['id'], 6);
                }
        }
} 
endif; // Warta_Flickr_Feed

