<?php
/**
 * Gallery Carousel Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Gallery_Carousel')) :
class Warta_Gallery_Carousel extends WP_Widget {
        /**
         * Default options for this widget
         * @var array
         */
        protected $default_form_data = array();
        
        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_gallery_carousel', // Base ID
                        __('[Warta] Gallery Carousel', 'warta'), // Name
                        array( 'description' => __( 'Images carousel from a gallery post type post', 'warta' ), ) // Args
                );
                
                $this->default_form_data = array(
                        'title'         => __( 'New title', 'warta' ),
                        'gallery_post'  => 0,
                        'caption_length'=> 60,
                        'hide_mobile'   => 0
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
                extract( wp_parse_args($instance, $this->default_form_data) ); 
?>
                <div>
                        <!--Title
                        =========-->
                        <p>
                                <label><?php _e( 'Title:', 'warta' ); ?>
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id( 'title' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'title' ); ?>" 
                                               type     ="text" 
                                               value    ="<?php echo esc_attr( $title ); ?>"
                                        >
                                </label>                     
                        </p>

                        <!--Gallery Post
                        ================ -->
                        <p>
                                <label><?php _e('Gallery post:', 'warta') ?>
                                        <select name="<?php echo $this->get_field_name( 'gallery_post' ) ?>" class="widefat">
<?php                                                   $the_query = new WP_Query( array(
                                                                'tax_query' => array(
                                                                        array(
                                                                                'taxonomy'  => 'post_format',
                                                                                'field'     => 'slug',
                                                                                'terms'     => array( 'post-format-gallery' )
                                                                        )
                                                                )
                                                        ) );

                                                        if ( $the_query->have_posts() ) : 
                                                                while ( $the_query->have_posts() ) : 
                                                                        $the_query->the_post(); ?>
                                                                        <option value="<?php the_ID() ?>" <?php selected($gallery_post, get_the_ID()) ?>>
                                                                                <?php the_title() ?>
                                                                        </option>
<?php                                                           endwhile; 
                                                        endif;
                                                        wp_reset_postdata(); ?>
                                        </select>
                                </label>
                        </p>

                        <!--Caption Length
                        ================== -->
                        <p>
                                <label><?php _e('Caption Length:', 'warta') ?>
                                        <input class    ="widefat" 
                                               name     ="<?php echo $this->get_field_name( 'caption_length' ); ?>" 
                                               type     ="number" 
                                               value    ="<?php echo (int) $caption_length; ?>"
                                        >
                                </label>
                                <small>How many characters of the caption do you want to show?</small>
                        </p>

                        <!--Hide on mobile devices
                        ========================== -->
                        <p>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'hide_mobile' ); ?>" value="1" <?php checked( $hide_mobile, 1) ?>> 
                                        <?php _e('Hide on mobile devices', 'warta') ?>
                                </label><br>
                                <small><?php _e('Recommended for better performance.', 'warta') ?></small>
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
                $new_instance                   = wp_parse_args($new_instance, $this->default_form_data);                
                $instance                       = array();
                $instance['title']              = sanitize_text_field( $new_instance['title'] );
                $instance['gallery_post']       = (int) $new_instance['gallery_post'];
                $instance['caption_length']     = (int) $new_instance['caption_length'];
                $instance['hide_mobile']        = (int) $new_instance['hide_mobile'];

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

                $title                  = apply_filters( 'widget_title', $title );                                                
                $matches_gallery        = warta_match_gallery( get_post( $gallery_post )->post_content, $gallery_post );
                $attachments            = NULL;

                if( $matches_gallery ) {                                
                        $attachments = get_posts( array(
                                'include'               => implode(',', $matches_gallery['image_ids']), 
                                'post_status'           => 'inherit', 
                                'post_type'             => 'attachment', 
                                'post_mime_type'        => 'image',
                        ) );
                }

                $data_lightbox_gallery  = 'gallery' . rand();
                $counter                = 0;

                if ( $attachments ) : ?>
                        <section class="<?php warta_widget_class( $args['id'], 6, TRUE, isset($args['is_pb']) ) ?> <?php if( $hide_mobile ) echo 'no-mobile' ?>">

<?php                           if( !empty($title) ) : ?>                        
                                        <header class="clearfix">
                                                <h4><?php echo strip_tags($title) ?></h4>
<?php                                           if(is_rtl()) : ?>
                                                        <a href="#<?php echo $data_lightbox_gallery ?>" class="control" data-slide="prev"><i class="fa fa-chevron-left"></i></a>  
                                                        <a href="#<?php echo $data_lightbox_gallery ?>" class="control" data-slide="next"><i class="fa fa-chevron-right"></i></a> 
<?php                                           else : ?>               
                                                        <a href="#<?php echo $data_lightbox_gallery ?>" class="control" data-slide="next"><i class="fa fa-chevron-right"></i></a> 
                                                        <a href="#<?php echo $data_lightbox_gallery ?>" class="control" data-slide="prev"><i class="fa fa-chevron-left"></i></a>                                  
<?php                                           endif // rtl ?>                                                
                                        </header>                            
<?php                           endif // title ?>

                                <div id="<?php echo $data_lightbox_gallery ?>" class="carousel slide carousel-small frame" data-ride="carousel">
                                        <div class="carousel-inner">  
<?php 
                                                foreach ( $attachments as $attachment ) : 
                                                        $caption                = wptexturize( $attachment->post_excerpt );
                                                        $caption_excerpt        = $caption 
                                                                                ? warta_the_excerpt_max_charlength( $caption_length, $caption )
                                                                                : ''; 
                                                        $attachment_medium      = wp_get_attachment_image_src( $attachment->ID, 'medium');
                                                        $attachment_huge        = wp_get_attachment_image_src( $attachment->ID, 'huge');
?>
                                                        <div class="item image <?php if( $counter++ === 0 ) echo 'active' ?>"
<?php                                                        echo Warta_Helper::get_image_sizes_data_attr( $attachment->ID ) ?>
                                                             data-img-sizes-wrapper=".carousel-inner">

<?php                                                           if( $hide_mobile ) : ?>
                                                                        <div data-src="<?php echo esc_url( $attachment_medium[0] ) ?>" 
                                                                             data-alt="<?php echo esc_attr( $caption ) ?>"></div>
<?php                                                           else : ?>
                                                                        <img src="<?php echo esc_url( $attachment_medium[0] ) ?>" 
                                                                             alt="<?php echo esc_attr( $caption ) ?>">
<?php                                                           endif; // image ?>

                                                                <div class="image-light"></div><!--.image-light-->
<?php
                                                                if( $caption_excerpt ): ?>
                                                                        <div class="caption">
                                                                                <h5><?php echo strip_tags( $caption_excerpt ) ?></h5>
                                                                        </div><!--.caption-->
<?php                                                           endif ?>             

                                                                <div class="container-link">
                                                                        <div class="link">
                                                                                <a href="<?php echo esc_url( get_attachment_link( $attachment->ID ) ) ?>"><i class="fa fa-link fa-flip-horizontal"></i></a>
                                                                                <a href="<?php echo esc_url( $attachment_huge[0] ) ?>" 
                                                                                   title="<?php echo esc_attr( $caption ) ?>" data-lightbox-gallery="<?php echo $data_lightbox_gallery ?>">
                                                                                        <i class="fa fa-search-plus"></i>
                                                                                </a>
                                                                        </div>
                                                                </div><!--.container-link-->
                                                        </div><!--.image-->
<?php                                           endforeach; // attachments ?>

                                        </div><!--.carousel-inner-->
                                </div><!--.carousel-->
<?php                           echo warta_image_shadow() ?>

                        </section><!--.widget-->
<?php                   
                        if( !isset($args['is_pb']) ) {
                                warta_add_clearfix( $args['id'], 6);
                        }
                        
                endif;
        }

} // class Warta_Gallery_Carousel
endif; // Warta_Gallery_Carousel