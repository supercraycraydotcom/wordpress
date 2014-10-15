<?php
/**
 * Set body background
 * 
 * @package Warta
 */

if( !function_exists('warta_body_bg') ) :    
/**
 * Set body background
 * 
 * @global array $friskamax_warta Theme option values
 */
function warta_body_bg() {
    global $friskamax_warta;
        
    $attachment_id = 0;
    
    if( isset($friskamax_warta['body_bg']['id']) && !!$friskamax_warta['body_bg']['id'] ) { 
        $attachment_id          = $friskamax_warta['body_bg']['id'];
        $attachment_src_huge    = wp_get_attachment_image_src($attachment_id, 'huge');
        $attachment_src_full    = wp_get_attachment_image_src($attachment_id, 'full');
    }
    
    if( $attachment_id ) : ?>
    
        <style>
            @media(min-width: 828px) {
                .boxed-style body  { background-image: url('<?php echo esc_url( $attachment_src_huge[0] ) ?>') !important }
            }

            @media(min-width: 1367px) { 
                .boxed-style body  { background-image: url('<?php echo esc_url( $attachment_src_full[0] ) ?>') !important }
            }
        </style>
        
    <?php endif;
}    
endif; // warta_body_bg
add_action('wp_head', 'warta_body_bg', 666);
