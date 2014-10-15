<?php
/**
 * Blockquote Shortcode.
 *
 * @package Warta
 */

if( !function_exists('warta_blockquote_shortcode') ) :
function warta_blockquote_shortcode( $atts, $content = '' ) {    
    extract( shortcode_atts( 
        array( 
            'source_title'  => '',
            'source_url'    => '',
            'style'         => ''       
        ), 
        $atts 
    ) );
        
    ob_start();
?>
        <blockquote <?php if( $style == 'reverse' ) { echo 'class="blockquote-reverse"'; } ?>> 
<?php       echo wp_kses_post( $content ); 
            if($source_title) :
?>
                <footer>
                    <cite title="<?php esc_attr($source_title) ?>">
<?php                   
                        if($source_url) { 
                            echo '<a href="' . esc_url ($source_url) . '">';                                    
                        }
                        
                        echo strip_tags($source_title);
                        
                        if($source_url) { 
                            echo '</a>';                                    
                        }
?>
                    </cite>
                </footer>
                
<?php       endif // $source_title ?>
        </blockquote>
<?php
    return ob_get_clean();
}
endif; // warta_blockquote_shortcode
add_shortcode( 'blockquote', 'warta_blockquote_shortcode' );