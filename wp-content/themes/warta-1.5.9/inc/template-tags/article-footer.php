<?php

/* 
 * Display article footer
 * 
 * @package Warta
 */

if( !function_exists( 'warta_article_footer') ) :
/**
 * Display article footer
 * 
 * @global array $friskamax_warta Warta theme options
 * @param array $args :
 *      - page        = page type
 *      - read_more   = ( boolean ) display read more button
 */
function warta_article_footer( $args = array() ) {
        global $friskamax_warta;
        
        extract( wp_parse_args( 
                $args, 
                array(
                        'page'      => 'archive',
                        'read_more' => NULL,
                ) 
        ) );
    
        $hide_post_meta_all = get_post_meta( get_the_ID(), 'friskamax_hide_post_meta_all', true );
        $display_tags       = $friskamax_warta["{$page}_post_meta"]['tags'] && !$hide_post_meta_all && get_the_tags();
        $display_more       = ( strlen(get_the_excerpt()) > (isset($friskamax_warta["{$page}_excerpt_length"]) ? $friskamax_warta["{$page}_excerpt_length"] : 320) ) 
                            || preg_match('/class="more-link"/is', get_the_content() );
        
        if( isset( $read_more ) ) {
            $display_more   = $read_more;
        }
?>
        <div class="footer <?php if( !$display_tags && !$display_more ) { echo 'no-padding'; } ?>">
<?php           
                if( $display_tags ) { 
                        the_tags('<ul class="tags"><li>', '</li><li>', '</li></ul>');                     
                } // tags

                if( $display_more ) : ?>
                        <div class="read-more">
                                <a class="btn btn-primary btn-sm" href="<?php the_permalink() ?>"><?php esc_attr_e('Read More', 'warta') ?></a> 
                        </div><!--.read-more-->
<?php           endif // read more ?>
                
        </div><!--.footer-->
<?php
}
endif; // warta_article_footer

