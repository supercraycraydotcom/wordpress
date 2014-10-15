<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
                warta_page_title( get_the_title(), '' ); 
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
                        $friskamax_warta_var['sidebar_counter'] = 0;
                        $fsmpb_display->display();
                
                // Standard page
                else: ?>
                        <div class="row">
                                <main id="main-content" class="col-md-8" role="main"> 
<?php                                   while ( have_posts() ) : 
                                                the_post(); 
                                                get_template_part( 'content', 'page' ); 
        
                                                // If comments are open or we have at least one comment, load up the comment template
                                                if ( comments_open() || '0' != get_comments_number() ) :
                                                        comments_template();
                                                endif;
                                        endwhile; ?>
                                </main>

<?php                           get_sidebar() ?>
                        </div>
<?php           endif; ?>
        </div>
</div><!--#content-->

<?php 
get_footer(); 