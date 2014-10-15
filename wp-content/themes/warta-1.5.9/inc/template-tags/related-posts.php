<?php
/**
 * Display related posts
 * 
 * @package Warta
 */

if( !function_exists('warta_related_posts') ) :
/**
 * Display related posts
 * 
 * @global array $friskamax_warta Warta theme options
 */
function warta_related_posts() {
        global $friskamax_warta;
        
        $tags   = get_the_tags();
        $cats   = get_the_category();

        $args   = array(  
                    'post__not_in'          => (array) get_the_ID(),  
                    'posts_per_page'        => 4, // Number of related posts to display.  
                    'ignore_sticky_posts'   => TRUE  
                );

        if ($tags) {  
                foreach($tags as $tag) {
                        $tag_ids[] = $tag->term_id; 
                }                         
                $args['tag__in'] = $tag_ids;
        } else {
                foreach ($cats as $cat) {
                        $cat_ids[] = $cat->term_id;
                }
                $args['category__in'] = $cat_ids; 
        }

        $the_query = new WP_Query( $args ); // The Query
        
        if( $the_query->have_posts() ) : ?>   

                <section class="widget"> 
<?php
                        if( $friskamax_warta['singular_related_title'] ) : ?>
                                <header class="clearfix">
                                        <h4><?php echo strip_tags($friskamax_warta['singular_related_title']) ?></h4>
                                </header>
<?php                   endif; ?>
                                
                        <div class="row">
<?php
                                while( $the_query->have_posts() ) : 
                                        $the_query->the_post(); // The Loop  
                                        $format = get_post_format() ? get_post_format() : 'standard'; // get post format
?>  
                                        <article class="article-small col-md-3 col-sm-6">  
<?php                   
                                                warta_featured_image( array(
                                                        'size'      => 'small',
                                                )); // featured image?>

                                                <!--Content-->
                                                <a href="<?php the_permalink() ?>"><h5><?php the_title() ?></h5></a>
<?php 
                                                        $related_meta   = wp_parse_args( 
                                                                                $friskamax_warta['singular_related_post_meta'], 
                                                                                array(
                                                                                        'date'          => 0,
                                                                                        'format'        => 0,
                                                                                        'comments'      => 0,
                                                                                        'views'         => 0,
                                                                                        'category'      => 0,
                                                                                )
                                                                        );
                                                        echo warta_posted_on(array(
                                                                'meta_date'         => $related_meta['date'],
                                                                'meta_format'       => $related_meta['format'],
                                                                'meta_comments'     => $related_meta['comments'],
                                                                'meta_views'        => $related_meta['views'],
                                                                'meta_category'     => $related_meta['category'],
                                                        )); 
?> 
                                                <hr class="visible-sm visible-xs">

                                        </article>
<?php 
                                endwhile; // $the_query->have_posts()                

                                wp_reset_postdata(); // Restore original Post Data                 
?>              
                        </div><!--.row-->
            
                </section><!--.widget-->    
<?php
        endif; // $the_query->have_posts()
}
endif; // warta_related_posts
