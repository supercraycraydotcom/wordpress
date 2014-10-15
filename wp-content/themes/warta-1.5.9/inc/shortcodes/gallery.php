<?php
/**
 * Replace core gallery shortcode
 * 
 * @package Warta
 */

if( !function_exists('warta_gallery_shortcode') ) :
/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @global array $friskamax_warta Warta theme options
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function warta_gallery_shortcode( $val, $attr ) {    
        global $friskamax_warta;
        
        // If using WordPress default style
        if( isset( $friskamax_warta['gallery_page_default'] ) && !!$friskamax_warta['gallery_page_default'] ) 
                return;
        
        // If using jetpack
        if( isset( $attr['type'] ) )
                return;
    
        $post = get_post();

        if ( ! empty( $attr['ids'] ) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if ( empty( $attr['orderby'] ) ) {
                $attr['orderby'] = 'post__in';
                    }
            $attr['include'] = $attr['ids'];
        }

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] ) {
                unset( $attr['orderby'] );
                    }
        }

        extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post ? $post->ID : 0,
            'columns'    => 3,
            'size'       => 'gallery',
            'include'    => '',
            'exclude'    => '',
            'link'       => ''
        ), $attr, 'gallery'));

        $id = intval($id);
        if ( 'RAND' == $order ) {
            $orderby = 'none';
            }

        if ( !empty($include) ) {
            $_attachments = get_posts( array(
                            'include'           => $include, 
                            'post_status'       => 'inherit', 
                            'post_type'         => 'attachment', 
                            'post_mime_type'    => 'image', 
                            'order'             => $order, 
                            'orderby'           => $orderby
                    ) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( !empty($exclude) ) {
            $attachments = get_children( array(
                            'post_parent'       => $id, 
                            'exclude'           => $exclude, 
                            'post_status'       => 'inherit', 
                            'post_type'         => 'attachment', 
                            'post_mime_type'    => 'image', 
                            'order'             => $order, 
                            'orderby'           => $orderby) );
        } else {
            $attachments = get_children( array(
                            'post_parent'       => $id, 
                            'post_status'       => 'inherit', 
                            'post_type'         => 'attachment', 
                            'post_mime_type'    => 'image', 
                            'order'             => $order, 
                            'orderby'           => $orderby
                    ) );
        }

        if ( empty($attachments) ) {
            return '';
            }

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
                    }
            return $output;
        }

        $columns                = intval($columns);                                
            $data_lightbox_gallery  = 'gallery' . rand();
            $output                 = "<div class='images'><ul class='da-thumbs clearfix col-{$columns}'>";

        foreach ( $attachments as $id => $attachment ) {
                    $caption        = wptexturize( $attachment->post_excerpt );
                    $caption_length = isset( $friskamax_warta['gallery_page_caption_length'] ) 
                                    ? $friskamax_warta['gallery_page_caption_length']
                                    : 60;
                    $excerpt        = !!$caption 
                                    ? '<h5 class="gallery-caption">' . warta_the_excerpt_max_charlength( $caption_length, $caption ) . '</h5>'
                                    : '';

                    /**
                     * Link
                     * -------------------------------------------------------------
                     */
            if ( ! empty( $link ) && 'file' === $link ) {         
                            $attachment_src = wp_get_attachment_image_src( $id, 'huge');
                            $image_link     = '<a '
                                                    . 'href="' . esc_url( $attachment_src[0] ) . '"'
                                                    . 'title="' . esc_attr( $caption ) . '" '
                                                    . 'data-lightbox-gallery="' . $data_lightbox_gallery . '">';
                    } elseif ( ! empty( $link ) && 'none' === $link ) {
                $image_link     = '<a title="' . esc_attr( $caption ) . '">';
                    } else {
                $image_link     = '<a href="' . get_attachment_link( $id ) . '" class="link-to-attachment-page" title="' . esc_attr( $caption ) . '">';
                    }

                    /**
                     * Caption & image size
                     * -------------------------------------------------------------
                     */
                    if( $columns > 6 ) {
                        $excerpt    = '';
                        $size       = 'thumbnail';  
                    } else if( $columns > 4 ) {
                        $excerpt    = '';
                        $size       = 'small';   
                    } else if( $columns > 3 ) {
                        $excerpt    = '<div class="image-caption">' . $excerpt . '</div>';
                        $size       = 'gallery';   
                    } else if( $columns > 1 ) {
                        $excerpt    = '<div class="image-caption">' . $excerpt . '</div>';
                        $size       = 'medium';                    
                    } else {
                        $excerpt    = '<div class="image-caption">' . $excerpt . '</div>';
                        $size       = 'large';
                    }

                    $attachment_src = wp_get_attachment_image_src( $attachment->ID, $size );
            $output         .= '<li>'
                                            . $image_link
                                                    . '<img '
                                                            . 'src="' . esc_url( $attachment_src[0] ) . '" '
                                                            . 'alt="' . esc_attr( $caption ) . '">'
                                                    . $excerpt
                                                    . '<span class="image-light"></span>'
                                            . '</a>'
                                    . '</li>';
        }

        $output .= "</ul></div>\n";

        return $output;
}
endif; // warta_gallery_shortcode
add_filter('post_gallery', 'warta_gallery_shortcode', 10, 2);