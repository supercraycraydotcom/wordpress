<?php
/**
 * Display social media icons
 * 
 * @package Warta
 */

if( !function_exists('warta_social_media')) :
/**
 * Display social media icons
 * 
 */
function warta_social_media($data = array(), $i_class = '') {
        global  $friskamax_warta_var, $friskamax_warta; 
           
        foreach ($friskamax_warta_var['social_media'] as $key => $value) : 
                if(!empty($data[$key])) : ?>
                        <li>
                                <a href="<?php echo esc_url($data[$key]) ?>" title="<?php echo esc_attr( $friskamax_warta_var['social_media'][$key] ) ?>" target="_blank">
                                <i class="<?php echo $i_class .' sc-'. esc_attr($key) ?>"></i>
                            </a>
                        </li>
<?php           endif; 
        endforeach;   
}
endif;