<?php
/**
 * Template Name: Full Width
 * 
 * @package Warta
 */

$friskamax_warta_var['page']      = 'page';
$friskamax_warta_var['html_id']   = 'blog-detail';
$friskamax_warta_var['full-width']= TRUE;

get_header(); 

// print page title
warta_page_title( get_the_title(), '' ); 

?>

</header><!--header-->

<div id="content">

    <div class="container">

        <div class="row">
            
            <!-- Main Content
            ============================================================ -->
            <main id="main-content" class="col-md-12" role="main">        
                                
                <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'content', 'page' ); ?>

                        <?php
                                // If comments are open or we have at least one comment, load up the comment template
                                if ( comments_open() || '0' != get_comments_number() ) :
                                        comments_template();
                                endif;
                        ?>

                <?php endwhile; // end of the loop. ?>

            </main><!-- #main -->
           
        </div><!--.row-->

    </div><!--.container -->

</div><!--#content-->

<?php get_footer(); ?>