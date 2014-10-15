<?php
/**
 * Custom CSS code
 */

if( !function_exists('warta_css_code')):
function warta_css_code() {
        global $friskamax_warta;
        
        // Logo
        if( isset( $friskamax_warta['logo']['id'] ) && !!$friskamax_warta['logo']['id'] ) :
                extract($friskamax_warta['logo']);
                if($height < 60) :
                        $padding = (60 - $height) / 2; ?>
                        <style>
                                #main-nav .navbar-header .navbar-brand {
                                        padding-top: <?php echo $padding ?>px;
                                        padding-bottom: <?php echo $padding ?>px;
                                }
                                #main-nav .navbar-header .navbar-brand img {
                                        height: <?php echo $height ?>px;
                                }
                        </style>
<?php           elseif($height >= 60) : ?>
                        <style>
                                #main-nav .navbar-header .navbar-brand {
                                        padding: 0;
                                }
                                #main-nav .navbar-header .navbar-brand img {
                                        height: 60px;
                                }
                        </style>
<?php           endif; 
        endif;
        
        // Custom CSS
        if( isset($friskamax_warta['css_code']) && !!trim($friskamax_warta['css_code']) ) : ?>
                <style><?php echo $friskamax_warta['css_code'] ?></style>
<?php   endif;
}
endif; 
add_action('wp_head', 'warta_css_code', 666);

