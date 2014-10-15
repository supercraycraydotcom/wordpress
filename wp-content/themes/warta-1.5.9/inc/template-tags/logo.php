<?php
/**
 * Set logo 
 * 
 * @package Warta
 */

if( !function_exists('warta_logo') ) :    
/**
 * Set logo
 * 
 * @global array $friskamax_warta Theme option values
 */
function warta_logo() {
        global $friskamax_warta;
        
        if( isset( $friskamax_warta['logo']['id'] ) && !!$friskamax_warta['logo']['id'] ) :
                extract($friskamax_warta['logo']); ?>

                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
<?php                     echo wp_get_attachment_image( $id, 'full' ) ?>
                </a>
<?php   endif;

}    
endif; // warta_logo
