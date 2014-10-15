<?php

if( !function_exists('warta_review_user_rating') ) :
/**
 * User rating on review box
 * =============================================================================
 */
function warta_review_user_rating() {    
    $id         = (int) $_REQUEST['id'];
    $new_value  = (float) $_REQUEST['value'];
    
    $user_rating = get_post_meta( $id, "friskamax_review_user_rating", true);
    
    if( !!$user_rating ) {
        $total  = $user_rating['value'] * $user_rating['count'];
        
        $user_rating['count']++;
        
        $user_rating['value'] = round( ( $new_value + $total ) / $user_rating['count'], 1 );
        
        update_post_meta( $id, 'friskamax_review_user_rating', $user_rating );
        
    } else {
        $user_rating['value'] = $new_value;
        $user_rating['count'] = 1;
        
        add_post_meta( $id, 'friskamax_review_user_rating', $user_rating );
    }
    
    echo json_encode( $user_rating );
    
    $_SESSION['friskamax_review_user_rating'][$id] = round( $new_value, 1 );

    die(); // this is required to return a proper result
}
endif; // warta_review_user_rating
add_action( 'wp_ajax_warta_review_user_rating', 'warta_review_user_rating' );
add_action( 'wp_ajax_nopriv_warta_review_user_rating', 'warta_review_user_rating' );