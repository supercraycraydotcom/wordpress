<?php
/**
 * Set page title background
 * 
 * @package Warta
 */

if( !function_exists('warta_title_bg') ) :    
/**
 * Set page title background
 * 
 * @global array $friskamax_warta Theme option values
 * @global array $friskamax_warta_var Theme variables
 */
function warta_title_bg() {
        global  $friskamax_warta, 
                $friskamax_warta_var;
        
        $attachment_id  = 0;
                        
        // custom img
        if( is_single() || is_page() || ( isset($GLOBALS['woocommerce']) && is_woocommerce() ) ) {
                $the_id = get_the_ID();
                
                if( isset($GLOBALS['woocommerce']) && is_woocommerce() ) {
                        $the_id = wc_get_page_id( 'shop' );
                }
                
                if( has_post_thumbnail() && get_post_meta( $the_id, 'friskamax_page_title_op', TRUE ) == 'featured' ) {
                        $attachment_id = get_post_thumbnail_id();
                } else  {
                        $attachment_id = (int) get_post_meta( $the_id, 'friskamax_page_title_bg', true );    
                }
        } elseif (is_category()) {
                $cat_id         = get_query_var('cat');
                $cat_meta       = get_option( "warta_cat_meta_$cat_id");
                
                if( isset($cat_meta['page_title_bg']) && !!$cat_meta['page_title_bg'] ) {
                        $attachment_id = (int) $cat_meta['page_title_bg'];
                }
        }
                
        
        // img from theme option
        if( !$attachment_id && isset( $friskamax_warta['title_bg']['id'] ) && !!$friskamax_warta['title_bg']['id'] ) {
                $attachment_id = (int) $friskamax_warta['title_bg']['id'];

                switch ( $friskamax_warta_var['page'] ) {        
                        case 'home':
                                if( $friskamax_warta['homepage_title_bg'] && $friskamax_warta['homepage_title_bg']['id'] )   
                                        $attachment_id = (int) $friskamax_warta['homepage_title_bg']['id'];
                                break;

                        case 'singular':
                                if( $friskamax_warta['singular_title_bg'] && $friskamax_warta['singular_title_bg']['id'] ) 
                                        $attachment_id = (int) $friskamax_warta['singular_title_bg']['id'];
                                break;

                        case 'archive':
                                if( $friskamax_warta['archive_title_bg'] && $friskamax_warta['archive_title_bg']['id'] ) 
                                    $attachment_id = (int) $friskamax_warta['archive_title_bg']['id'];
                                break;

                        case 'page':
                                if( $friskamax_warta['page_title_bg'] && $friskamax_warta['page_title_bg']['id'] )  
                                        $attachment_id = (int) $friskamax_warta['page_title_bg']['id'];
                                break;
                } // $friskamax_warta_var['page']
        }

        if( !!$attachment_id ) : 
                $attachment_large   = wp_get_attachment_image_src($attachment_id, 'large');
                $attachment_huge    = wp_get_attachment_image_src($attachment_id, 'huge');
                $attachment_full    = wp_get_attachment_image_src($attachment_id, 'full');                
?>
                <style>
                        #title { 
                                background-image: url('<?php echo esc_url( $attachment_large[0] ) ?>') !important;
                                height          : <?php echo $attachment_large[2] ?>px; 
                        }

                        @media(min-width: 731px) {
                                #title { 
                                        background-image: url('<?php echo esc_url( $attachment_huge[0] ) ?>') !important;
                                        height          : <?php echo $attachment_huge[2] ?>px;
                                }
                        }

                        @media(min-width: 1367px) { 
                                #title { 
                                        background-image: url('<?php echo esc_url( $attachment_full[0] ) ?>') !important;
                                        height          : <?php echo $attachment_full[2] ?>px; 
                                }
                        }
                </style>

<?php   endif; // $attachment_id
}    
endif; // warta_title_bg
add_action('wp_head', 'warta_title_bg', 666);
