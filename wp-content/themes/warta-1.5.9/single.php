<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Warta
 */
global $friskamax_warta, $friskamax_warta_var;

$friskamax_warta_var['page']      = 'singular';
$friskamax_warta_var['html_id']   = 'blog-detail';

get_header();

?>
<!-- Please call pinit.js only once per page -->
<script type="text/javascript" async  data-pin-color="red" data-pin-height="28" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>
<!-- Luminate Ad -->


</header>

<?php
warta_page_title(
    get_post_format() == 'aside' ? '': get_the_title(),
    get_the_category_list( _x( ' / ', 'Used between category list items.', 'warta' ) )
);
?>

<div id="content" style="padding-bottom: 20px;">
    <div class="container">
        <div class="row">
            <main id="main-content" class="col-md-8" role="main">
                <div class="row"><?php dynamic_sidebar('singular-before-content-section'); ?></div>
                <?php while (have_posts()) :
                    the_post();

                    // Content
                    if ($postFormat = get_post_format()) :

                        switch ($postFormat) {
                            case 'video':
                                get_template_part('content', 'single-video');
                                break;
                            case 'noad':
                                get_template_part('content', 'single-noad');
                                break;
                        }

                    else :

                        get_template_part( 'content', 'single' );
                    endif; ?>

                    <?php if( isset( $friskamax_warta['singular_author_info'] ) && !!$friskamax_warta['singular_author_info'] ) : ?>
                    <section class="widget author">

                        <!--widget title-->
                        <?php if(isset($friskamax_warta['singular_author_info_title']) && !!$friskamax_warta['singular_author_info_title']) : ?>
                            <header class="clearfix">
                                <h4><?php echo strip_tags( $friskamax_warta['singular_author_info_title'] ) ?></h4>
                            </header>
                        <?php endif ?>

                        <!--avatar-->
                        <a href ="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>"
                           class="avatar" title="<?php echo esc_attr( sprintf( __('View all posts by %s', 'warta'), get_the_author() ) ) ?>">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 75 ) ?>
                            <div class="image-light"></div>
                        </a>

                        <!--Author's Name-->
                        <span class="name"><?php echo get_the_author_link() ?></span>
                        <br>

                        <!--Author's Bio-->
                        <p><?php echo get_the_author_meta('description') ?></p>

                        <!--Author's social media links-->
                        <ul class="social clearfix">
                            <?php foreach ($friskamax_warta_var['social_media'] as $key => $value) :
                                $url = get_the_author_meta( "friskamax_{$key}" );
                                if( !empty($url) ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( get_the_author_meta( "friskamax_{$key}" ) ) ?>" title="<?php echo $value ?>">
                                            <i class="sc-sm sc-<?php echo $key ?>"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>

                    <div class="row"><?php dynamic_sidebar('singular-after-content-section'); ?></div>
                    <?php if( isset( $friskamax_warta['singular_related'] ) && !!$friskamax_warta['singular_related'] ) : ?>
                    <?php warta_related_posts(); ?>

                <?php endif; ?>
                <?php endwhile; ?>

            </main>
            <?php /* @TODO removed sidebar from this id temp fix */ if (get_the_ID() != 7846) : ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
        </div>
    </div>
</div><!--#content-->

<?php get_footer(); ?>