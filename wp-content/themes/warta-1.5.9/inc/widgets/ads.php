<?php
/**
 * Advertisement Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Advertisement')) :
class Warta_Advertisement extends WP_Widget {
        
        /**
         * Default options for this widget
         * @var array
         */
        protected $default_form_data = array();

        /**
         * Register widget with WordPress
         */
        function __construct() {
                parent::__construct(
                        'warta_ads', // Base ID
                        __('[Warta] Advertisement', 'warta'), // Name
                        array( 'description' => __( 'Advertisement.', 'warta' ), ) // Args
                );
                
                $this->default_form_data = array(
                        'title'         => __( 'New title', 'warta' ),
                        'ad_type'       => 'img',
                        'img_url'       => '',
                        'ad_url'        => '',
                        'ad_code'       => '',
                        'hide_on_mobile'=> 0,
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

                $title      = apply_filters( 'widget_title', $title );
                $classes    = warta_widget_class($args['id'], 12, FALSE, isset($args['is_pb']));
                $classes    .= !!$hide_on_mobile ? ' hidden-xs' : '';
                $classes    .= !!$hide_on_mobile && ( $ad_type == 'img' ) ? ' no-mobile' : '';
                $id         = 'id' . rand();
?>
                <section class="widget <?php echo $classes ?>" id="<?php echo $id ?>">            
<?php                   echo !empty($title) ? $args['before_title'] . $title . $args['after_title'] : '' ?>
                
                        <div class="frame thick">
<?php                           if( $ad_type === 'img' ) : // Banner image ?>
                                        <a href="<?php echo esc_url($ad_url) ?>" target="_blank">
<?php                                           if( $hide_on_mobile ) : ?>
                                                        <div data-src="<?php echo esc_url($img_url) ?>" data-alt="<?php echo esc_attr($title) ?>"></div>
<?php                                           else : ?>
                                                        <img src="<?php echo esc_url($img_url) ?>" alt="<?php echo esc_attr($title) ?>">
<?php                                           endif ?>
                                        </a>
<?php                           else :  
                                        if($hide_on_mobile) : ?>
                                                <script>if( jQuery(window).width() <= 768 ) jQuery('#<?php echo $id ?>').remove();</script>
<?php                                   endif;
                                        echo $ad_code; 
                                endif; ?>
                        </div>
                        <?php echo warta_image_shadow() ?>            
                </section><!--.widget-->
<?php
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {                        
                extract( wp_parse_args( $instance, $this->default_form_data ) );
?>
                <div class="fsmh-container">                    
                        <!--Title
                        ========= -->
                        <p>
                                <label>
                                        <?php _e('Title:', 'warta') ?> 
                                        <input class    = "widefat" 
                                               id       = "<?php echo $this->get_field_id( 'title' ); ?>" 
                                               name     = "<?php echo $this->get_field_name( 'title' ); ?>" 
                                               type     = "text" 
                                               value    = "<?php echo esc_attr( $title ); ?>"
                                        >
                                </label>
                        </p>
                    
                        <!--Ad Type
                        ===========-->
                        <p>
                                <label>
                                        <?php _e('Advertisement type:', 'warta') ?>
                                        <select 
                                                name    ="<?php echo $this->get_field_name( 'ad_type' ) ?>" 
                                                id      ="<?php echo $this->get_field_id('ad_type') ?>"
                                                class   ="widefat"
                                        >
                                                <option value="img"     <?php selected( $ad_type, 'img' ) ?>>   <?php _e('Image', 'warta') ?>           </option>
                                                <option value="js"      <?php selected( $ad_type, 'js' ) ?>>    <?php _e('JavaScript', 'warta') ?>      </option>
                                        </select>
                                </label>
                        </p>

                        <!--Ad Type: Image > Image URL
                        ============================== -->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('ad_type') ?>", "compare":"equal", "value":"img" }]'>
                                <label><?php _e('Image URL:', 'warta') ?> 
                                        <input class="widefat" 
                                               name     ="<?php echo $this->get_field_name( 'img_url' ); ?>" 
                                               type     ="url" 
                                               value    ="<?php echo esc_url( $img_url ); ?>"
                                        >
                                </label>
                                <small><?php _e('Recommended image size on main section is 730px wide and in sidebar section is 340px wide.', 'warta') ?></small>
                        </p>

                        <!--Ad Type: Image > Ad URL
                        =========================== -->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('ad_type') ?>", "compare":"equal", "value":"img" }]'>
                                <label><?php _e('Advertisement URL:', 'warta') ?> 
                                        <input class    ="widefat" 
                                               name     ="<?php echo $this->get_field_name( 'ad_url' ); ?>" 
                                               type     ="url" 
                                               value    ="<?php echo esc_url( $ad_url ); ?>"
                                        >
                                </label>
                        </p>

                        <!--Ad Type: JavaScript > Ad Code
                        ================================= -->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('ad_type') ?>", "compare":"equal", "value":"js" }]'>
                                <label><?php _e('Advertisement code:', 'warta') ?> 
                                        <textarea rows  ="8" 
                                                  class ="widefat" 
                                                  name  ="<?php echo $this->get_field_name( 'ad_code' ); ?>" 
                                                  type  ="text"
                                        ><?php echo esc_textarea( $ad_code ) ?></textarea>
                                </label>
                                <small>
                                        <?php _e('Please use responsive ad unit in order to be displayed correctly in all screen sizes. '
                                        . 'If you\'re using Google Adsense, you can find the tutorial <a target="_blank" href="https://support.google.com/adsense/answer/3213689">here</a>.', 'warta') ?>
                                </small>
                        </p>
                    
                        <!--Hide on mobile
                        ================== -->
                        <p>
                                <label>
                                        <input name     ="<?php echo $this->get_field_name( 'hide_on_mobile' ); ?>" 
                                               type     ="checkbox" 
                                               value    ="1" 
                                               <?php checked($hide_on_mobile, 1) ?>
                                        >
                                        <?php _e('Hide on mobile devices', 'warta') ?> 
                                </label><br>
                                <small><?php _e('Recommended for better performance.', 'warta') ?></small>
                        </p>                    
                </div>
<?php 
        }

        /**
         * Sanitize widget form values as they are saved.
             * =====================================================================
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) { 
                $new_instance   = wp_parse_args($new_instance, $this->default_form_data);
                $instance       = array();                
                
                $instance['title']              = sanitize_text_field( $new_instance['title'] );
                $instance['ad_type']            = sanitize_text_field( $new_instance['ad_type'] );
                $instance['img_url']            = esc_html( $new_instance['img_url'] );
                $instance['ad_url']             = esc_html( $new_instance['ad_url'] );
                $instance['ad_code']            = current_user_can('unfiltered_html')
                                                ? $new_instance['ad_code']
                                                : stripslashes( wp_filter_post_kses( addslashes($new_instance['ad_code']) ) ); // wp_filter_post_kses() expects slashed
                $instance['hide_on_mobile']     = !!$new_instance['hide_on_mobile'] ? 1 : 0;

                return $instance;
        }
} // class Warta_Advertisement
endif; 