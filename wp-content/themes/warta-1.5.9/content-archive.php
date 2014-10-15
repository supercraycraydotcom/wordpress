<?php
/**
 * The template for displaying Archive posts.
 *
 * @package Warta
 */

global $friskamax_warta, $friskamax_warta_var;
?>
</header><!--header-->

<div id="content">
        <div class="container">
                <div class="row">
                        <main id="main-content" class="col-md-8" role="main">
                                <div class="row aside">
<?php                                   $friskamax_warta_var['sidebar_counter'] = 0;
                                        dynamic_sidebar('archive-before-content-section');  ?>                    
                                </div>
<?php 
                                if ( have_posts() ) : 
                                        while ( have_posts() ) : 
                                                the_post();                                 
                                                get_template_part( 'content', isset($friskamax_warta['archive_layout']) ? $friskamax_warta['archive_layout'] : 1 );
                                        endwhile; 
                                else : 
                                        get_template_part( 'content', 'none' ); 
                                endif; 
?>
                                <div class="row aside">
<?php                                   $friskamax_warta_var['sidebar_counter'] = 0;
                                        dynamic_sidebar('archive-after-content-section'); ?>
                                </div>

<?php                           warta_paging_nav(); ?>
                        </main>

<?php                   get_sidebar(); ?>
                </div>
        </div>
</div><!--#content-->

<?php 
get_footer();