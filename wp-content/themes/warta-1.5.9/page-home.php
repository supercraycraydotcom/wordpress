<?php
/**
 * Template Name: Home Page
 *
 * @since 3.0
 *
 * @author Ben Rasmusen <mail@benrasmusen.com>
 */



global $post, $detect;
$page_id = $post->ID;

get_header(); ?>

<div class="row">
    <div role="main" class="large-8 columns two-column-for-small">

        <section>

            <?php

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            die(print_r($paged));

            query_posts( array(
                'posts_per_page' => 16,
                'paged' => $paged
            ) );

            if ( have_posts() ):
            $i=0;
            while ( have_posts() ):

            the_post();

            if ($i == 3):
                ?>
                <!-- begin 3lift tag -->
                <script src="http://ib.3lift.com/ttj?inv_code=parentsociety_mainfeed"></script>
                <!-- end 3lift tag -->
            <?php
            endif;
            $i++;
            if($i==8) {
            ?>
        </section>

        <section> <?php /* restart section for articles */ ?>
            <?php

            }
            endwhile; ?>

            <div class="pagination-centered post-pagination">

                <ul class="pagination">

                    <?php posts_nav_link('<li>|</li>','&laquo; Newer','Older &raquo;'); ?>

                </ul>

            </div>

            <?php endif; // if ( have_posts() ) ?>
        </section>

    </div>

    <aside class="large-4 columns">

        <?php dynamic_sidebar( 'Global Sidebar' ); ?>

    </aside>
</div>
<?php get_footer(); ?>
