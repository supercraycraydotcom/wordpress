<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Warta
 */
// dirty mobile check... @TODO clean up
$mobCheck = new Mobile_Detect();
if (!$mobCheck->isMobile() || $mobCheck->isTablet()) :
// Get $friskamax_warta global variables
global $friskamax_warta_var;

$friskamax_warta_var['sidebar_counter'] = 0;

$the_id = get_the_ID(); 
if( isset($GLOBALS['woocommerce']) && is_woocommerce() ) {
        $the_id = wc_get_page_id( 'shop' );
}

$custom_sidebar_content = get_post_meta( $the_id, 'friskamax_custom_sidebar', true );      // Old version, deprecated
$custom_sidebar         = get_post_meta( $the_id, 'friskamax_sidebar', true );             // Widget area
?>

<aside class="col-md-4">    
        <div class="row">
                <?php do_action( 'before_sidebar' ); ?>

                <?php 
                        if      ( !!$custom_sidebar && dynamic_sidebar($custom_sidebar) ) :
                        elseif  ( !!$custom_sidebar_content ) : ?>
                                <div class="entry-content col-md-12">
<?php                                   $content    = apply_filters('the_content', $custom_sidebar_content);
                                        $content    = str_replace(']]>', ']]&gt;', $content);
                                        echo $content; ?>
                                </div>
<?php                   elseif  ( $friskamax_warta_var['page'] === 'home'       && dynamic_sidebar( 'home-sidebar-section' ) ) : 
                        elseif  ( $friskamax_warta_var['page'] === 'archive'    && dynamic_sidebar( 'archive-sidebar-section' ) ) : 
                        elseif  ( $friskamax_warta_var['page'] === 'singular'   && dynamic_sidebar( 'singular-sidebar-section' ) ) : 
                        elseif  ( $friskamax_warta_var['page'] === 'page'       && dynamic_sidebar( 'page-sidebar-section' ) ) : 
                        elseif  ( dynamic_sidebar( 'default-sidebar-section' ) ) : 
                        endif; 
                ?>
        </div><!--.row-->
</aside><!--aside-->
<?php endif; //End dirty mobile check ?>