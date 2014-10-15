<?php
/**
 * @package Warta
 */

global $friskamax_warta;
$featured_media         = warta_match_featured_media();
$matches_blockquote     = warta_match_quote();
$match_image            = warta_match_image();
$match_gallery          = warta_match_gallery();

$format                 = get_post_format();
$display_more           = NULL;
$no_image               = !has_post_thumbnail() ? 'no-image' : '';

// Get no-image class
switch ($format) {
        case 'image':
                $no_image = !has_post_thumbnail() && !$match_image ? 'no-image' : '';
                break;
        case 'gallery':
                $no_image = !has_post_thumbnail() && !$match_gallery ? 'no-image' : '';
                break;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( "article-large $no_image" ); ?>>
<?php   // Display featured image and title
        if( has_post_thumbnail() ) : 
                warta_featured_image();
        elseif($format == 'image' && !!$match_image) :
                warta_featured_image( $match_image );
        elseif($format == 'gallery' && !!$match_gallery) :
                $attachment_src = wp_get_attachment_image_src( $match_gallery['image_ids'][0], 'huge');        
                warta_featured_image( array(
                        'image'     => wp_get_attachment_image( $match_gallery['image_ids'][0], 'large' ),
                        'image_url' => $attachment_src[0]
                ) );
        else:
                switch ($format) :
                        case 'audio':
                        case 'video':
                        case 'image':
                        case 'gallery': ?>
                                <a href="<?php the_permalink() ?>" class="title"><h4><?php the_title() ?></h4></a>
<?php                           echo warta_post_meta();
                                if( !!$featured_media ) : ?>
                                        <div class="featured-media"><?php echo $featured_media ?></div>
<?php                           endif; 
                                break;
                        case 'aside':                 
                                echo '<hr class="no-margin">';
                                echo warta_post_meta();            
                                break;
                        default: ?>
                                <a href="<?php the_permalink() ?>" class="title"><h4><?php the_title() ?></h4></a>
<?php                           echo warta_post_meta();
                                break;
                endswitch; 
        endif;
        
        // Display content
        if($format == 'aside') {
                $display_more = FALSE;
                the_content();
        } else if($format == 'quote' && !!$matches_blockquote) {
                $content        = apply_filters( 'the_content', get_the_content() );
                $display_more   = strlen(trim($content)) > strlen($matches_blockquote);
                echo $matches_blockquote;
        } else {
                        echo "<p>" . warta_the_excerpt_max_charlength( isset($friskamax_warta['archive_excerpt_length']) ? $friskamax_warta['archive_excerpt_length'] : 320 ) . "</p>";
        }

        // Display footer
        warta_article_footer( array('read_more' => $display_more) ) ?>                                
</article>