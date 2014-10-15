<?php

/**
 * Display featured image
 * 
 * @package Warta
 */

if( !function_exists('warta_featured_image') ) :
/**
 * Display featured image
 * 
 * @global type $friskamax_warta Warta theme option
 * @param array $args : 
 *      - size          : thumbnail size, ex: .article-large = large, .article-medium = medium, ...
 *      - page          : current page type
 *      - image         : custom image html code
 *      - image_url     : custom large image url
 *      - featured_media: featured media html code
 *      - caption       : (boolean) display caption
 */
function warta_featured_image( $args = array() ) {
        global $friskamax_warta;   
        
        $format = get_post_format() ? get_post_format() : 'standard'; // Set default post format
                
        extract( wp_parse_args( 
                $args, 
                array(
                        'size'                  => 'large',
                        'page'                  => 'archive',
                        'image'                 => '',
                        'image_url'             => '',
                        'featured_media'        => '',
                        'caption'               => '',
                ) 
        ) );
        
        $image          = !!$image ? $image : get_the_post_thumbnail( NULL, $size );
        $attachment_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'huge');
        $image_url      = !!$image_url 
                        ? esc_url( $image_url ) 
                        : esc_url( $attachment_src[0] );
        $post_meta      = wp_parse_args($friskamax_warta["{$page}_post_meta"], array(
                                'date'          => 0,
                                'format'        => 0,
                                'category'      => 0,
                                'categories'    => 0,
                                'tags'          => 0,
                                'author'        => 0,
                                'comments'      => 0,
                                'views'         => 0, 
                                'review_score'  => 0,
                        ));
        $icons          = wp_parse_args(
                                $friskamax_warta["{$page}_icons"],
                                array(
                                        'author'    => 0,
                                        'comments'  => 0,
                                        'format'    => 0,
                                )
                        );
        
        /**
         * Article large
         * =============
         */
        if( $size == 'large' ) : ?>

                <div class="frame thick clearfix">

                        <a href="<?php echo $image_url ?>" 
                           title="<?php the_title() ?>" data-zoom>
<?php                                   echo $image ?>
                                <div class="image-light"></div>
                        </a><!--thumbnail image-->

                        <div class="icons">
<?php                   
                                if( $icons['author'] ): ?>
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ) ?>" 
                                           title="<?php echo sprintf( __('View all posts by %s', 'warta'), get_the_author()) ?>">
                                                <?php echo get_avatar( get_the_author_meta('ID'), 65 ) ?>
                                        </a>
<?php                           endif; // author 

                                if( $icons['format'] ) : ?>
                                        <a href="<?php echo esc_url( get_post_format_link($format) ) ?>" 
                                           title="<?php echo esc_attr( sprintf( __('View all %s posts', 'warta'), $format ) ) ?>">
                                                <i class="dashicons dashicons-format-<?php echo $format ?>"></i>
                                        </a>
<?php                           endif; // post format 

                                if( $icons['comments'] && get_comments_number() > 0 ) : ?>
                                        <a href="<?php echo esc_url( get_comments_link() ) ?>" 
                                           title="<?php echo esc_attr( sprintf( _n( "%d comment", "%d comments", get_comments_number(), 'warta' ), get_comments_number() ) ) ?>">
                                                <i class="fa fa-comments"></i><span class="comment"><?php echo warta_format_counts( get_comments_number() ) ?></span>
                                        </a>
<?php                           endif // comments ?>

                        </div><!--.icons-->

<?php                   if( $page != 'singular' ) : ?>
                                <a href="<?php the_permalink() ?>"><h4><?php the_title() ?></h4></a><!--title-->
<?php                   endif;

                        echo warta_posted_on(
                                array(
                                        'date_format'       => isset($friskamax_warta["{$page}_date_format"]) ? $friskamax_warta["{$page}_date_format"] : 'F j, Y',
                                        'meta_date'         => $post_meta['date'],
                                        'meta_format'       => $post_meta['format'],
                                        'meta_comments'     => $post_meta['comments'],
                                        'meta_views'        => $post_meta['views'],
                                        'meta_category'     => $post_meta['category'],
                                        'meta_categories'   => $post_meta['categories'],
                                        'meta_author'       => $post_meta['author'],
                                        'meta_review_score' => $post_meta['review_score'],
                                        'meta_edit'         => TRUE
                                ),
                                $page == 'singular' ? 'pull-right' : ''
                        );
?>
                </div><!--.frame-->                            
<?php           echo warta_image_shadow(); // shadow
        
        /**
         * Article medium
         * ==============
         */
        elseif( $size == 'medium' ) : 
                            
                // Featured image
                if( has_post_thumbnail() ) : ?>
                        <div class="frame">
                                <div class="image">
<?php                                   $medium_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
                                        <img src="<?php echo $medium_src[0] ?>" alt="<?php the_title() ?>" <?php echo Warta_Helper::get_image_sizes_data_attr() ?>>
                                        <div class="image-light"></div>
<?php                                   if( $caption ) : ?>
                                                <div class="caption">
                                                        <span class="dashicons dashicons-format-<?php echo $format ?>"></span>
                                                        <h5><?php the_title() ?></h5>
                                                </div>  
<?php                                   endif; // caption
                                        echo warta_image_links() // hover links ?>
                                </div><!--.image-->
                        </div><!--.frame-->
<?php                   echo warta_image_shadow(); // shadow
                
                // Custom image
                elseif( $image ) : ?>
                        <div class="frame">
                                <div class="image">
                                        <?php echo $image ?>
                                        <div class="image-light"></div>
<?php                                   if( $caption ) : ?>
                                                <div class="caption">
                                                        <span class="dashicons dashicons-format-<?php echo $format ?>"></span>
                                                        <h5><?php the_title() ?></h5>
                                                </div>  
<?php                                   endif; // caption
                                        echo warta_image_links( $image_url ) // hover links ?>
                                </div><!--.image-->
                        </div><!--.frame-->
<?php                   echo warta_image_shadow(); // shadow

                // Featured media
                elseif( $featured_media ) : // has_post_thumbnail() ?>
                        <div class="featured-media"><?php echo $featured_media; ?></div><!--.featured-media-->                                
<?php                   if( $caption ) : ?>
                                <h5><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
<?php                   endif; // caption 
                     
                // Post format placeholder
                else : ?>
                        <div class="frame">
                                <div class="image">
                                        <div class="dashicons format-placeholder dashicons-format-<?php echo $format ?>"></div>
                                        <div class="image-light"></div>
<?php                                   if( $caption ) : ?>
                                                <div class="caption">
                                                        <h5><?php the_title() ?></h5>
                                                </div>  
<?php                                   endif; // caption
                                        echo warta_image_links( '', TRUE ) // hover links ?>
                                </div><!--.image-->
                        </div><!--.frame-->
<?php                   echo warta_image_shadow(); // shadow
                endif; // has_post_thumbnail
            
        /**
         * Article tiny
         * ============
         */
        elseif( $size == 'tiny' || $size == 'small' ) :
                
                if(has_post_thumbnail()) : 
                        $tiny_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $size == 'small' ? 'small' : 'thumbnail' ); ?>
                        <a href="<?php the_permalink() ?>" class="image">
                                <img src="<?php echo $tiny_src[0] ?>" alt="<?php the_title() ?>" <?php echo Warta_Helper::get_image_sizes_data_attr() ?>>
                                <div class="image-light"></div>
                                <div class="link">
                                        <span class="dashicons dashicons-format-<?php echo $format ?>"></span>
                                </div>
                        </a>
<?php           else : ?>
                        <a href="<?php the_permalink() ?>" class="image">
                                <div class="dashicons format-placeholder dashicons-format-<?php echo $format ?>"></div>
                                <div class="image-light"></div>
                        </a>
<?php           endif; // has_post_thumbnail
            
        endif; // article type
}
endif; // warta_featured_image