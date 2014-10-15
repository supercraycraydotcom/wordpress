<?php
/**
 * Template Homepage Version 1
 * 
 * @package Warta
 */

global $friskamax_warta, $friskamax_warta_var;                  // Get Warta Theme global variables
$friskamax_warta_var['page']      = 'home';           // set the current page
$friskamax_warta_var['html_id']   = 'home-version-1'; // Set html ID

get_header();

?>

<!-- FULL WIDTH CAROUSEL
============================================================================ -->
<?php if( isset($friskamax_warta['carousel']) && !!$friskamax_warta['carousel'] ) warta_carousel('large') ?>

</header><!--header-->

<div id="content">

        <!-- Main Container 
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div class="container">
                            
            <div class="row">
                
                <?php 
                    /**
                     * Top Sections Widgets Area
                     * ---------------------------------------------------------
                     */
                    $friskamax_warta_var['sidebar_counter'] = 0;
                    dynamic_sidebar('home-top-section'); 
                ?>                
                <div class="clearfix"></div>

                <!-- MAIN CONTENT
                ============================================================ -->
                <div id="main-content" class="col-md-8">

                    <div class="row">
                        
                        <?php                         
                            /**
                             * Main Section Widgets Area
                             * -------------------------------------------------
                             */
                            $friskamax_warta_var['sidebar_counter'] = 0;
                            dynamic_sidebar('home-main-section'); 
                        ?>

                    </div>

                </div><!--#main-content-->
                
                <?php 
                    /**
                     * Sidebar
                     * ---------------------------------------------------------
                     */
                     get_sidebar();
                ?>
                <div class="clearfix"></div>
                
                <?php
                    /**
                     * Bottom Sections Widgets Area
                     * ---------------------------------------------------------
                     */
                    $friskamax_warta_var['sidebar_counter'] = 0;
                    dynamic_sidebar('home-bottom-section') 
                ?>

            </div><!--.row-->

        </div><!--.container-->

</div><!--#content-->

<?php get_footer(); ?>