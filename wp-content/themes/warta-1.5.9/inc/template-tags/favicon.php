<?php

if( !function_exists('warta_favicon')):
function warta_favicon() {
        global $friskamax_warta;
        
        if( isset($friskamax_warta['favicon']['id']) && !!$friskamax_warta['favicon']['id'] ) : 
                extract($friskamax_warta['favicon']); ?>
                <link rel       ="shortcut icon" 
                      type      ="<?php echo get_post_mime_type($id) ?>" 
                      href      ="<?php echo $url ?>" 
                      sizes     ="<?php echo "{$width}x{$height}" ?>"
                >
<?php   endif;
}
endif; 
add_action('wp_head', 'warta_favicon', 666);

