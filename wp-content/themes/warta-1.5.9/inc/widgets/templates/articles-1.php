<?php
/**
 * Article v1 widget layout
 * 
 * @package Warta
 */

if( !isset($args['is_pb']) ) {
        // Column counter. Used for calculating clearfix.
        $friskamax_warta_var['sidebar_counter'] += warta_is_full( $args['id'] ) ? 6 : 0; 
}
?>

<section class="headline <?php warta_widget_class( $args['id'], 12, TRUE, isset($args['is_pb'])) ?>">
<?php   $this->display_title(); 

        while ( $the_query->have_posts() ) : 
                $the_query->the_post();
?>
                <article class="article-medium">
                        <div class="row">
                                <div class="<?php echo ( warta_is_sidebar($args['id']) || warta_is_full($args['id'])  ) ? 'col-sm-12' : 'col-sm-6' ?>">
<?php                                   warta_featured_image( $this->get_featured_image_args(FALSE) ) ?>              
                                </div><!--1st col-->

                                <div class="<?php echo ( warta_is_sidebar($args['id']) || warta_is_full($args['id']) ) ? 'col-sm-12' : 'col-sm-6' ?>">
<?php                                   if(get_post_format() == 'aside') :
                                                $this->display_post_meta();
                                                the_content();
                                        else : ?>
                                                <a href="<?php the_permalink() ?>" class="title">
                                                        <h4><?php the_title() ?></h4>
                                                </a>
<?php                                           $this->display_post_meta(); ?>
                                                <p><?php echo warta_the_excerpt_max_charlength($excerpt) ?></p>
<?php                                   endif; ?>
                                </div><!--2nd col-->
                        </div>
                </article>
<?php   endwhile;  ?>
</section>