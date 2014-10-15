<?php
/**
 * Article v3 widget layout
 * 
 * @package Warta
 */

if( !isset($args['is_pb']) ) {
        // Column counter. Used for calculating clearfix.
        $friskamax_warta_var['sidebar_counter'] += warta_is_main( $args['id'] ) || warta_is_full( $args['id'] ) ? 6 : 0; 
}
?>
<section class="<?php warta_widget_class( $args['id'], 6, TRUE, isset($args['is_pb'])  ) ?>">
<?php   $this->display_title();

        while ( $the_query->have_posts() ) : 
                $the_query->the_post(); 
                        
                // Display the article
                if($counter++ === 0) : // first article ?>
                        <article class="article-medium">
<?php                           warta_featured_image( $this->get_featured_image_args() );
                                if(get_post_format() == 'aside') {
                                        the_content();
                                } else {
                                        echo '<p>' . warta_the_excerpt_max_charlength($excerpt) . '</p>';
                                }                                
                                $this->display_post_meta() ?>
                                <hr>
                        </article>
<?php           else: // > 1 articles 
                        $this->display_article_tiny();
                endif;
        endwhile;  ?>
</section>