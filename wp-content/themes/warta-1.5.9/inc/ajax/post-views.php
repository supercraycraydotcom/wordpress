<?php
/**
 * Warta Post Views Counter
 *
 * @package Warta
 */

if(!function_exists('warta_set_post_views')) :
       /**
        * Add/update post meta views count
        * @param int $postID
        */
        function warta_set_post_views() {
                global $friskamax_warta;
                
                $is_ajax = isset($_POST['id']); 
                
                if( $is_ajax ) {
                        $postID = (int) $_POST['id']; 
                } elseif( is_single() && isset($friskamax_warta['ajax_post_views']) && !$friskamax_warta['ajax_post_views'] ) {
                        $postID = get_the_ID();                              
                } else {
                        return;
                }
                                
                $count = get_post_meta($postID, 'warta_post_views_count', true);
                if($count == '') {
                        $count = 0;
                } else {
                        $count++;
                }

                update_post_meta($postID, 'warta_post_views_count', $count);

                if($is_ajax) {
                        die();
                }
        }
endif; 
add_action( 'before', 'warta_set_post_views' );
add_action( 'wp_ajax_warta_set_post_views', 'warta_set_post_views' );
add_action( 'wp_ajax_nopriv_warta_set_post_views', 'warta_set_post_views' );


/**
if(!function_exists('warta_get_post_views')) :
        function warta_get_post_views() {        
                $ids    = $_GET['ids'];
                $data   = array();
                
                if(is_array($ids) && !!$ids) {
                        foreach ($ids as $id) {
                                $id             = (int) $id;
                                $views_count    = (int) get_post_meta($id, 'warta_post_views_count', true);                                
                                $data[$id]      = array(
                                                        'title' => esc_attr( sprintf( _n( "%d view", "%d views", $views_count, 'warta' ), $views_count ) ),
                                                        'value' => warta_format_counts( $views_count )
                                                );                                
                        }
                }
                
                echo json_encode($data);
                                
                die();
        }
endif;
add_action( 'wp_ajax_warta_get_post_views', 'warta_get_post_views' );
add_action( 'wp_ajax_nopriv_warta_get_post_views', 'warta_get_post_views' );
*/