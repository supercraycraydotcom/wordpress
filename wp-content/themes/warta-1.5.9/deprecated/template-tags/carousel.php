<?php
/**
 * Display carousel
 * 
 * @package Warta
 */

if( !function_exists('warta_carousel') ) :
/**
 * Display carousel
 * 
 * @global array $friskamax_warta Warta Options
 * @param string $size Carousel size
 */
function warta_carousel($size = 'large') {
    global $friskamax_warta;
    
    if( !isset( $friskamax_warta['carousel_caption_animation'] ) ) 
            $friskamax_warta['carousel_caption_animation'] = '';
    
    $args = array(
                'posts_per_page'        => 200,
                'ignore_sticky_posts'   => TRUE
    );
    
    switch ($friskamax_warta['carousel_data']) {
        case 'cats':
            $args['category__in'] = $friskamax_warta['carousel_categories'];
            break;
        
        case 'tags':
            $args['tag__in'] = $friskamax_warta['carousel_tags'];
            break;
                
        case 'posts':
            $args['post__in'] = $friskamax_warta['carousel_posts'];
            break;
    }
    
    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) {
        $counter        = 0;
        $is_large       = $size == 'large';
        $is_no_mobile   = $friskamax_warta['carousel_hide_mobile'];
        $id             = $is_large ? 'carousel-large' : 'carousel-medium';
        $no_mobile      = $is_no_mobile ? 'no-mobile' : '';
        $output         = '';
        
        if( !$is_large ) {
            $output     .= '<section class="widget col-md-12 ' . $no_mobile . '">'
                            . '<div class="frame thick">';
        }
        
        $output                 .= '<div id="' . $id . '" class="' . $id . ' carousel slide ' . $no_mobile  . '" data-ride="carousel" data-interval="' . $friskamax_warta['carousel_interval'] . '">';
        $indicators             = '<ol class="carousel-indicators">';
        $inner                  = '<div class="carousel-inner">';
        
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            
            if( has_post_thumbnail() ) {
                $full       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
                $huge       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'huge');
                $large      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                
                $active     = $counter == 0 ? 'active' : '';
                
                /**
                 * Indicators
                 * -------------------------------------------------------------
                 */
                $indicators         .= '<li data-target="#' . $id . '" data-slide-to="' . $counter . '" class="' . $active . '"></li>';
                
                /**
                 * Items
                 * -------------------------------------------------------------
                 */
                $inner              .= '<div class="item ' . $active . '">';
                
                if( $is_no_mobile ) {
                    
                    /**
                     * Image
                     * ---------------------------------------------------------
                     */
                    $inner              .= '<div data-alt="' . get_the_title() . '" ';                
                    
                    if($is_large) {
                        $inner              .= 'data-small="' . $large[0] . '"'
                                            . 'data-medium="' . $huge[0] . '"'
                                            . 'data-large="' . $full[0] . '">';
                    } else { 
                        $inner              .= 'data-src="' . $large[0] . '">';
                    }

                    $inner              .= '</div>'; // Image
                    
                } else { // $is_no_mobile
                    
                    /**
                     * Image
                     * ---------------------------------------------------------
                     */
                    $inner              .= '<img alt="' . get_the_title() . '" ';                
                    
                    if($is_large) { 
                        $inner              .= 'data-small="' . $large[0] . '"'
                                            . 'data-medium="' . $huge[0] . '"'
                                            . 'data-large="' . $full[0] . '"';
                    }
                    
                    $inner                  .= 'src="' . $large[0] . '">'; // image
                                        
                } // $is_no_mobile
                
                $inner                  .= '<div class="carousel-caption" data-animation="' . $friskamax_warta['carousel_animation'] .'" data-speed="' . $friskamax_warta['carousel_caption_animation'] . '">' // caption
                                            . '<div><a href="' . get_permalink() . '"><h1>' . get_the_title() . '</h1></a></div>';
                                
                if( !!$friskamax_warta['carousel_excerpt_length'] && get_the_excerpt() != '' ) {                           
                    $inner                  .= '<div class="hidden-xs hidden-sm"><p>' . warta_the_excerpt_max_charlength( $friskamax_warta['carousel_excerpt_length'] ) . '</p></div>';
                }
                    
                $inner                  .= '</div>' // .carousel-caption
                                    . '</div>'; // .item
                $counter++;        
                
            } // has_post_thumbnail()
            
            if( $counter == $friskamax_warta['carousel_count'] ) { 
                break;
            }
            
        } // while $the_query->have_posts()
        
        $indicators             .= '</ol>'; // .carousel-indicators
        $inner                  .= '</div>'; // .carousel-inner
        
        if( $is_large ) {
            $output             .= $indicators;
        }
        
        $output                 .= $inner
                                . '<div class="image-light"></div>'
                                . '<a class="left carousel-control" href="#' . $id . '" data-slide="prev"><span class="fa fa-chevron-left"></span></a>'
                                . '<a class="right carousel-control" href="#' . $id . '" data-slide="next"><span class="fa fa-chevron-right"></span></a>'
                            . '</div>'; // .carousel
        
        if( !$is_large ) {
            $output         .= '</div>' // .frame.thick
                            . warta_image_shadow()
                        . '</section>'; // .widget
        }
        
        if( $counter > 0 ) { 
            echo $output;
        }
        
    } // $the_query->have_posts()
    
    wp_reset_postdata();  // Restore original Post Data 
}
endif; // warta_carousel