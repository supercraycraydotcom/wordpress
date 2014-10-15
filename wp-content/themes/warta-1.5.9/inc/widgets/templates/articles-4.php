<?php
/**
 * Article v2 widget layout
 * 
 * @package Warta
 */

// Column counter. Used for clearfix.
if( !isset($args['is_pb']) ) {
        $friskamax_warta_var['sidebar_counter'] += warta_is_main( $args['id'] ) ? 3 : 0; 
        $friskamax_warta_var['sidebar_counter'] += warta_is_full( $args['id'] ) ? 6 : 0; 
}
?>

<section class="<?php warta_widget_class( $args['id'], 3, TRUE, isset($args['is_pb']) ) ?>">
<?php   $this->display_title();

        while ( $the_query->have_posts() ) : 
                $the_query->the_post(); 
                                
                if( $counter++ === 0 ) : // first article ?>
                        <article class="article-small">                                   
<?php                           warta_featured_image( array(
                                        'size'      => 'small',
                                )); 
?>
                                <h5><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
<?php                           $this->display_post_meta(); ?>                                    
                                <hr>
                        </article>
<?php           else : // > 1 articles ?>
                        <article>                                    
                                <h5><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
<?php                           $this->display_post_meta(); ?> 
                                <hr>                                    
                        </article>
<?php           endif; // articles counter 
        endwhile;  ?>
</section>