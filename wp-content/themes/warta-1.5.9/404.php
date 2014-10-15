<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Warta
 */

$friskamax_warta_var['html_id'] = 'page-404';
$friskamax_warta_var['page']    = 'page';

get_header(); ?>

</header><!--header-->

<div id="content">
    
    <div class="container">

        <h1>404</h1>
        <p><?php _e( 'Sorry, the page you requested was not found.', 'warta' ); ?></p>            
        <button class="btn btn-primary" data-back>Back to previous page</button>
        
    </div><!--.container-->

</div><!-- #content -->

<?php get_footer(); ?>

<script>
    +function( $ ) { "use strict"; 
        $('[data-back]').click( function() {
            window.history.back();
        } );
    } (jQuery);
</script>