<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Warta
 */

global $friskamax_warta_var;

?>

<article class="article-large entry-content">    

    <?php if(has_post_thumbnail()) : $attachment_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'huge'); ?>
    
        <div class="frame thick">
            <a href="<?php echo esc_url( $attachment_src[0] ) ?>" data-zoom title="<?php the_title() ?>">
               <?php isset($friskamax_warta_var['full-width']) && !!$friskamax_warta_var['full-width'] ? the_post_thumbnail('huge') : the_post_thumbnail('large') ?>
               <div class="image-light"></div>
            </a>
        </div>
        <?php echo warta_image_shadow(); ?>
        
    <?php endif // has_post_thumbnail() ?>
    
    <?php the_content(); ?>
    <?php
        wp_link_pages( array(
            'before'        => '<div class="page-links">' . __( 'Pages:', 'warta' ),
            'after'         => '</div>',
            'link_before'   => '<span>',
            'link_after'    => '</span>'
        ) );
    ?>            
    
</article><!-- #post-## -->

<?php echo warta_posted_on( array('meta_edit' => TRUE), 'edit-link') ?>

<div class="margin-bottom-45"></div>
