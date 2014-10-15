<?php
/**
 * @package Warta
 */

global $friskamax_warta;

$featured_media     = warta_match_featured_media();
$matches_gallery    = warta_match_gallery();
$matches_image      = warta_match_image();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article-medium'); ?>>
        <div class="row">
                <div class="col-sm-6">
                <?php   switch (get_post_format()) :
                                case 'audio': 
                                case 'video': 
                                        warta_featured_image( array(
                                                'size'          => 'medium',
                                                'featured_media'=> $featured_media
                                        )); 
                                        break;

                                case 'gallery': 
                                        $attachment_src = wp_get_attachment_image_src( $matches_gallery['image_ids'][0], 'large');
                                        warta_featured_image( array(
                                                'size'              => 'medium',
                                                'featured_media'    => $featured_media,
                                                'image'             => wp_get_attachment_image( $matches_gallery['image_ids'][0], 'medium'),
                                                'image_url'         => $attachment_src[0]
                                        )); 
                                        break;

                                case 'image': 
                                        warta_featured_image( array(
                                                'size'              => 'medium',
                                                'featured_media'    => $featured_media,
                                                'image'             => isset( $matches_image['image'] ) ? $matches_image['image'] : '',
                                                'image_url'         => isset( $matches_image['image_url'] ) ? $matches_image['image_url'] : ''
                                        ));  
                                        break;
                                
                                default: 
                                        warta_featured_image( array(
                                                'size' => 'medium'
                                        ));  
                                        break;
                        endswitch; ?>
                </div>
                
                <div class="col-sm-6">  
<?php                   if(get_post_format() == 'aside') :
                                echo warta_post_meta('', FALSE);
                                the_content(); 
                        else : ?>                        
                                <a href="<?php the_permalink() ?>" class="title"><h4><?php the_title() ?></h4></a>
<?php                           echo warta_post_meta('', FALSE) ?>      
                                <p><?php echo warta_the_excerpt_max_charlength( isset($friskamax_warta['archive_excerpt_length']) ? $friskamax_warta['archive_excerpt_length'] : 320 ) ?></p>   
<?php                   endif; ?>
                </div>
        </div>
                
        <?php   warta_article_footer(array(
                'read_more' => get_post_format() == 'aside' ? FALSE : NULL
        ) ) ?>
</article>
 