<?php
/**
 * @package Warta
 */

global $friskamax_warta;

$hide_featured_image    = get_post_meta( get_the_ID(), 'friskamax_hide_featured_image_main', true );
$hide_post_meta_main    = get_post_meta( get_the_ID(), 'friskamax_hide_post_meta_main', true );

$rest_content           = '';
$featured_media         = warta_match_featured_media('^', $rest_content);
preg_match('/^\[carousel.+?ids="([0-9 ,]+?)".*?\]/is', get_the_content(), $matches_carousel); 

$warta_review_box       = new Warta_Review_Box();
$userAgent = new Mobile_Detect();
global $page, $pages, $numpages;
?>

<?php // MOBILE ADs ?>
<?php if ($userAgent->isMobile() && ($page < $numpages) && !$userAgent->isTablet()) : ?>
    <div style="text-align:center; padding-top: 5px;">
        <div style="font-size: 10px;">Advertisement</div>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- 300x100 Mobile Ad -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:320px;height:100px"
             data-ad-client="ca-pub-4528087481844577"
             data-ad-slot="5745754243"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

<?php // TABLET ADs ?>
<?php elseif ($userAgent->isTablet() && ($page < $numpages)) : ?>
    <div class="adunit">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- leaderboard -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-4528087481844577"
             data-ad-slot="2271573049"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

<?php // DESKTOP ADs ?>
<?php elseif ($page < $numpages) :?>
    <div class="adunit">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- leaderboard -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-4528087481844577"
             data-ad-slot="2271573049"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" style="border-bottom: none !important;" 
<?php   post_class(
                'article-large entry-content clearfix ' . 
                (!get_the_content() ? 'no-padding-bottom no-border-bottom' : '') 
        ); 
?>>    
<?php   // Featured image
        if( has_post_thumbnail() && !$hide_featured_image ) :  
                warta_featured_image( array( 'page' => 'singular' ) ); ?>      
                <div class="margin-bottom-15"></div>      
<?php   // No featured image
        else :            
                if( !$hide_post_meta_main ) {
                        //echo '<hr class="no-margin-top">';                
                       // echo warta_post_meta();                
                        //echo '<hr>';
                }                 
        endif;
        // Link pages
        // Go to www.addthis.com/dashboard to customize your tools
?>
        <div class="addthis_sharing_toolbox"></div>

<?php
        // Review box & content
        if( $warta_review_box->position() == 'top' ) { 
                $format = get_post_format();
                
                if($format == 'audio' || $format == 'video' && !!$featured_media) {
                        echo    "<div class='featured-media'>{$featured_media}</div>" .
                                '<div class="margin-bottom-15"></div>';

                        $warta_review_box->display();

                        $rest_content = apply_filters( 'the_content', $rest_content );
                        $rest_content = str_replace( ']]>', ']]&gt;', $rest_content );

                        echo $rest_content;
                } elseif($format == 'gallery' && !!$matches_carousel) {
                        $content = str_replace( $matches_carousel[0], '', get_the_content());
                        $content = apply_filters( 'the_content', $content );
                        $content = str_replace( ']]>', ']]&gt;', $content );

                        echo do_shortcode( $matches_carousel[0] );                        
                        $warta_review_box->display(); 
                        echo $content;
                } else {
                        $warta_review_box->display();
                        the_content();
                }
        } else if( $warta_review_box->position() == 'bottom' ) {
                the_content();
                $warta_review_box->display();
        } else {
               the_content(); 
        } 
        
 ?>
</article>

<?php // MOBILE ADs ?>
<?php if ($userAgent->isMobile() && !$userAgent->isTablet() && ($page < $numpages)) : ?>

    <div style="text-align:center; padding-bottom:8px;">
        <div style="font-size: 10px;">Advertisement</div>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- 300x250 Mobile Ad -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:300px;height:250px"
             data-ad-client="ca-pub-4528087481844577"
             data-ad-slot="9636387047"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

    <hr style="padding-bottom: 15px;">

<?php // TABLET ADs ?>
<?php elseif ($userAgent->isTablet() && ($page < $numpages)) : ?>
    <!-- 336 x 280 Bottom -->
    <div style="text-align:center; padding-top:17px;">
        <div style="font-size: 10px;">Advertisement</div>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- 336 x 280 Bottom -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:336px;height:280px"
             data-ad-client="ca-pub-4528087481844577"
             data-ad-slot="5947354244"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <hr>

<?php // DESKTOP ADs ?>
<?php elseif ($page < $numpages) : ?>

    <!-- 336 x 280 Bottom -->
    <div style="text-align:center; padding-top:17px;">
        <div style="font-size: 10px;">Advertisement</div>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- 336 x 280 Bottom -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:336px;height:280px"
             data-ad-client="ca-pub-4528087481844577"
             data-ad-slot="5947354244"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <hr>

<?php endif; ?>


<?php // Link Pages // ?>
<?php $maxpages = $wp_query->max_num_pages; ?>

<?php if ($numpages > 1) : ?>
    <div class="page-link-container" style="text-align: center !important;">
        <?php
        // This shows the Previous link
        wp_link_pages( array( 'before' => '<div class="page-link-nextprev" style="display: inline-block !important;">',
                              'after' => '</div>', 'previouspagelink' => '<span class="previous">Back</span>', 'nextpagelink' => '',
                              'next_or_number' => 'next' ) );
        ?>


        <div class="page-count" style="display: inline-block !important;">
            <?php echo( $page.' of '.count($pages) ); ?>
        </div>
        <?php
        // This shows the Next link
        wp_link_pages( array( 'before' => '<div class="page-link-nextprev" style="display: inline-block !important;">', 'after' => '</div>', 'previouspagelink' => '',
                              'nextpagelink' => '<span class="next">Next</span>', 'next_or_number' => 'next' ) );
        ?>
    </div>
<?php endif; ?>

<?php if ($userAgent->isMobile() && !$userAgent->isTablet()) : ?>
    <div class="sswpds-social-wrap col-lg-6 col-lg-offset-3" style="padding: 17px 0px;">
        <a href="<?php echo esc_url('http://www.facebook.com/sharer.php?u='
            .get_permalink()); ?>" target="_blank">
            <i class="fa fa-facebook-square"></i> Share on Facebook
        </a>
    </div>
<?php endif; ?>

<div style="margin-top: 20px;">
    <?php comments_template('/comments-facebook.php'); ?>
</div>

<?php get_template_part('partials/content', 'ad'); ?>

<?php if ($page > 3) : ?>
    <div class="col-md-4 col-xs-12 floating-share-bar">
        <div class="fb-share-button col-xs-7 text-center" style="border-radius: 5px; background-color: #2a5697; padding: 4px 6px; font-size: 23px">
            <a href id="fb-floating-share">
                <i class="fa fa-facebook-square"></i> Share
            </a>
        </div>
        <div class="fb-like-button col-xs-4 col-xs-offset-1 text-center">
            <div class="fb-like" data-href="https://www.facebook.com/supercraycray" data-layout="button_count"
                 data-action="like" data-show-faces="false" data-share="false"></div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function() {
            jQuery('#fb-floating-share').click(function() {
                event.preventDefault();
                FB.ui({
                    method: 'share',
                    href: '<?php echo get_permalink(); ?>'
                },
                function(response) {});
            })
        })
    </script>
<?php endif ?>