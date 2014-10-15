<?php
/**
 * The template for displaying Woocommerce pages.
 * 
 * @package Warta
 */

$friskamax_warta_var['page']      = 'page';
$friskamax_warta_var['html_id']   = 'blog-detail';

get_header(); 

// Carousel
if( !!get_post_meta( $post->ID, 'warta_full_width_carousel_enable', TRUE) ) {
        $warta_full_width_carousel = new Warta_Posts_Carousel();
        $warta_full_width_carousel->widget(array('is_large' => TRUE), get_post_meta( $post->ID, 'warta_full_width_carousel_options', TRUE));
} 
// Page title
else {        
        if(is_front_page()) {
                warta_page_title( get_bloginfo( 'name' ), get_bloginfo('description') );
        } else { 
                warta_page_title( woocommerce_page_title(FALSE), '' ); 
        }
} ?>
</header>

<div id="content">
        <div class="container">                
<?php           $fsmpb_display = new Fsmpb_Display(array(
                        'main'  => array(
                                'before_title'  => '<header class="clearfix"><h4 class="widget-title">',
                                'after_title'   => '</h4></header>',
                                'id'            => 'singular-before-content-section',
                        )
                ));

                // Page builder
                if($fsmpb_display->is_pb()) :
                        $fsmpb_display->display();
                
                // Standard page
                else: ?>
                        <div class="row">
                                <main id="main-content" class="col-md-8" role="main"> 
<?php                                   woocommerce_content(); ?>
                                </main>

<?php                           get_sidebar() ?>
                        </div>
<?php           endif; ?>
        </div>
</div><!--#content-->

<?php 
get_footer(); 