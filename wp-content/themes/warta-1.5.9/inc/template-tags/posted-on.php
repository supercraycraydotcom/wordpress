<?php
/**
 * Returns HTML with meta information for the current post-date/time and author
 * 
 * @package Warta
 */

if ( ! function_exists( 'warta_posted_on' ) ) :
/**
 * Returns HTML with meta information for the current post-date/time and author.
 * =============================================================================
 * @param array $args The post meta that should be displayed (boolean: 
 * $meta_date, $meta_format, $meta_category, $meta_categories, $meta_author, 
 * $meta_comments, $meta_views, $meta_review_score, $meta_edit)
 * 
 * @param string $class Additional css class for the container
 * @return string
 */
function warta_posted_on( $args = array(), $class='' ) {
    $defaults       = array( 
                                'date_format'        => 'M j, Y',
                                'meta_date'          => 0,
                                'meta_format'        => 0,
                                'meta_category'      => 0,
                                'meta_categories'    => 0,
                                'meta_tags'          => 0,
                                'meta_author'        => 0,
                                'meta_comments'      => 0,
                                'meta_views'         => 0, 
                                'meta_review_score'  => 0,
                                'meta_edit'          => 0
                    );
    $args           = wp_parse_args( $args, $defaults );
    
    extract($args);  
    
    $archive_year   = esc_attr( get_the_time('Y') ); 
    $archive_month  = esc_attr( get_the_time('m') ); 
    $archive_day    = esc_attr( get_the_time('d') ); 
    $category       = get_the_category();
    $category       = !!$category ? $category[0] : 0;
    $views_count    = (int) get_post_meta(get_the_ID(), 'warta_post_views_count', true);
    $post_format    = get_post_format();
    $output         = '';
    
    /**
     * Date
     * -------------------------------------------------------------------------
     */
    if($meta_date) {
        $output .= '<a href="'. esc_url( get_day_link( $archive_year, $archive_month, $archive_day) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'warta' ), get_the_date() ) ) . '">'
                    . '<i class="fa fa-clock-o"></i> ' 
                . get_the_time($date_format) . '&nbsp;</a> ';
    }  
    
    /**
     * Post format
     * -------------------------------------------------------------------------
     */
    if( $meta_format && $post_format ) {        
        $output .= '<a href="'. esc_url(get_post_format_link( $post_format ) ) . '" title="' . esc_attr( sprintf( __( "View all %s posts", 'warta' ), $post_format ) ) . '">'
                    . '<i class="dashicons dashicons-format-' . $post_format . '"></i>&nbsp;' 
                . ucfirst($post_format) . '&nbsp;</a> ';
    }
    
    /**
     * Category
     * -------------------------------------------------------------------------
     */
    if($meta_category) {
        $output .= '<a href="'. esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts under %s category", 'warta' ), $category->name ) ) . '">'
                    . '<i class="fa fa-folder"></i> ' . esc_html( $category->cat_name )
                . '&nbsp;</a> ';
    } 
    
    /**
     * Categories
     * -------------------------------------------------------------------------
     */
    if($meta_categories) {       
        $categories = get_the_category();
        $separator  = _x( ', ', 'Used between list items, there is a space after the comma.', 'warta' );
        $counter    = 0;
        
        if($categories){
            foreach($categories as $category) {
                if($counter++ === 0) {             
                    $output .= '<a href="'. esc_url( get_category_link( $category->term_id ) ) .'" title="' . esc_attr( sprintf( __( "View all posts under %s category", 'warta' ), $category->name ) ) . '">'
                                . '<i class="fa fa-folder"></i> ' . strip_tags( $category->cat_name )
                            . '</a>' . $separator;
                } else {
                    $output .= '<a href="'. esc_url( get_category_link( $category->term_id ) ) .'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'warta' ), $category->name ) ) . '">'
                                . strip_tags( $category->cat_name )
                            . '</a>' . $separator;
                }
            }
            $output = trim($output, $separator) . ' &nbsp;';
        }
    }
    
    /**
     * Author
     * -------------------------------------------------------------------------
     */
    if($meta_author) {
        $output .= '<a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( sprintf( __( "View all posts by %s", 'warta' ), get_the_author() ) ) . '">'
                    . '<i class="fa fa-user"></i> ' . esc_html( get_the_author() )
                . '&nbsp;</a> ';
    }  
    
    /**
     * Comments
     * -------------------------------------------------------------------------
     */
    if($meta_comments) { 
        $output .= '<a href="'. esc_url( get_comments_link() ) . '" title="' . esc_attr( sprintf( _n( "%d comment", "%d comments", get_comments_number(), 'warta' ), get_comments_number() ) ) . '">'
                    . '<i class="fa fa-comments"></i> ' 
                . warta_format_counts( get_comments_number() ) . '&nbsp;</a> ';
    } 
    
    /**
     * Views
     * -------------------------------------------------------------------------
     */
    if($meta_views) {
        $output .= '<a href="'. esc_url( get_permalink() ) . '" title="' . esc_attr( sprintf( _n( "%d view", "%d views", $views_count, 'warta' ), $views_count ) ) . '">'
                        . '<i class="fa fa-eye"></i> '
                        . '<span class="post-view-count" data-id="' . get_the_ID() . '">' . warta_format_counts( $views_count ) . '</span>'
                . '&nbsp;</a> ';
    }
    
    /**
     * Review score
     * -------------------------------------------------------------------------
     */
    $score = (float) get_post_meta( get_the_ID(), 'friskamax_review_total', true );
    
    if( $meta_review_score && $score ) { 
        $output .= '<a href="'. esc_url( get_permalink() ) . '" title="' . $score . '">'
                    . '<span data-rateit-value="' . $score . '" data-rateit-readonly="true" class="rateit"></span>' 
                . '&nbsp;</a> ';
    }
    
    /**
     * Edit
     * -------------------------------------------------------------------------
     */
    if( $meta_edit && get_edit_post_link() ) {
        $output .= '<a href="' . esc_url( get_edit_post_link() ) . '" title="' . __('Edit post', 'warta') . '"><i class="fa fa-pencil"></i> ' . __('Edit', 'warta') . '</a>';
    }
    
    
    if( $output ) {
            $output = '<p class="post-meta ' . $class . '">' . apply_filters('warta_posted_on', $output);
            $output .= '</p>';
    }
    
    return $output;
}
endif; // warta_posted_on




if( !function_exists('warta_post_meta') ) :
/**
 * Display post meta for article that has icons
 * =============================================================================
 * @global array $friskamax_warta Warta theme options
 * @global array $friskamax_warta_var Warta theme variables
 * @param string $class Custom class
 * @return string
 */
function warta_post_meta( $class='', $icon = TRUE ) {
        global $friskamax_warta, $friskamax_warta_var;  
        
        $page           = $friskamax_warta_var['page'];
        $post_meta      = wp_parse_args($friskamax_warta["{$page}_post_meta"], array(
                                'date'          => 0,
                                'format'        => 0,
                                'category'      => 0,
                                'categories'    => 0,
                                'tags'          => 0,
                                'author'        => 0,
                                'comments'      => 0,
                                'views'         => 0, 
                                'review_score'  => 0,
                        ));
        $icons          = wp_parse_args(
                                $friskamax_warta["{$page}_icons"],
                                array(
                                        'author'    => 0,
                                        'comments'  => 0,
                                        'format'    => 0,
                                )
                        );
                                                
        return  warta_posted_on(array(
                        'date_format'       => isset($friskamax_warta["{$page}_date_format"]) ? $friskamax_warta["{$page}_date_format"] : 'F j, Y',
                        'meta_date'         => $post_meta['date'],
                        'meta_views'        => $post_meta['views'],
                        'meta_review_score' => $post_meta['review_score'],
                        'meta_category'     => $post_meta['category'],
                        'meta_categories'   => $post_meta['categories'],
                        'meta_format'       => $post_meta['format']    || ($icon && $icons['format']),
                        'meta_comments'     => $post_meta['comments']  || ($icon && $icons['comments']),
                        'meta_author'       => $post_meta['author']    || ($icon && $icons['author']),
                        'meta_edit'         => TRUE
                ), $class );
}
endif;

