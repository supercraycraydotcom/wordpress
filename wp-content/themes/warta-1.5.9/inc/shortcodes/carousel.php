<?php
/**
 * Carousel Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_carousel_shortcode') ) :
function warta_carousel_shortcode( $atts, $content = '' ) {    
        extract( shortcode_atts( 
                array( 
                        'ids'  => '',
                ), 
                $atts 
        ) );

        if( $ids ) : 
                $unique_id = rand();
                ob_start();
?>                                
                <div class="frame thick">
                        <div id="carousel-medium-<?php echo $unique_id ?>" class="carousel slide carousel-medium" data-ride="carousel">
                                <div class="carousel-inner">
<?php                                   
                                        $attachments = get_posts( array(
                                                'include'           => $ids, 
                                                'post_status'       => 'inherit', 
                                                'post_type'         => 'attachment', 
                                                'post_mime_type'    => 'image', 
                                        ) );
                                        
                                        foreach ($attachments as $key => $attachment) : 
                                                $huge       = wp_get_attachment_image_src( $attachment->ID, 'huge');
                                                $large      = wp_get_attachment_image_src( $attachment->ID, 'large');
                                                $caption    = wptexturize( $attachment->post_excerpt );                                                 
?>                                          
                                                <div class="item <?php if( $key == 0 ) echo 'active' ?>">
                                                        <a href="<?php echo $huge[0] ?>" title="<?php echo $caption ?>" data-lightbox data-lightbox-gallery="carousel-shortcode-<?php echo $unique_id ?>">
                                                                <img src="<?php echo $large[0] ?>" alt="<?php echo $caption ?>">
                                                        </a>
<?php                                                   if( $caption ) : ?> 
                                                                <div class="carousel-caption">
                                                                        <div><h1><?php echo $caption ?></h1></div>
                                                                </div>
<?php                                                   endif ?>     
                                                </div>
                                    
<?php                                   endforeach; ?>
                                </div>

                                <div class="image-light"></div>

                                <a class="left carousel-control" href="#carousel-medium-<?php echo $unique_id ?>" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                                <a class="right carousel-control" href="#carousel-medium-<?php echo $unique_id ?>" data-slide="next"><span class="fa fa-chevron-right"></span></a>

                        </div><!--#carousel-widget-->
                </div><!--.frame.thick-->
<?php           echo warta_image_shadow(); ?>
                <div class="margin-bottom-15"></div>
                
<?php 
                return ob_get_clean();
        endif;
}
endif; // warta_carousel_shortcode
add_shortcode( 'carousel', 'warta_carousel_shortcode' );