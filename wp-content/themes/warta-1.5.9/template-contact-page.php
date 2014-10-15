<?php
/**
 * Template Name: Contact Page
 * 
 * @package Warta
 */

require dirname(__FILE__) . '/template-contact-page-header.php';
?>

<div id="content">            
        <div class="container">
                <div class="row">            
                        <main id="main-content" class="col-md-8" role="main"> 
                                
                                <!-- CONTACT INFO  -->
                                <section class="widget">

                                    <?php if( $friskamax_warta['contact_page_contact_info_title'] ) : ?>
                                        <header class="clearfix"><h4><?php echo strip_tags( $friskamax_warta['contact_page_contact_info_title'] ) ?></h4></header>
                                    <?php endif ?>

                                    <div class="entry-content">
                                        <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
                                    </div>

                                </section>

                                <!-- MESSAGE FORM 
                                ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                                <section class="widget message-form">

                                    <?php if( $friskamax_warta['contact_page_contact_form_title'] ) : ?>
                                        <header class="clearfix"><h4><?php echo $friskamax_warta['contact_page_contact_form_title'] ?></h4></header>
                                    <?php endif ?>

                                    <?php if( isset( $friskamax_warta['contact_page_before_form'] ) && !!$friskamax_warta['contact_page_before_form'] ) echo apply_filters('the_content', $friskamax_warta['contact_page_before_form']) ?>

                                    <?php if( $error_name || $error_email || $error_message ) : ?>
                                        <div class="alert alert-danger">
                                            <?php _e("Please check if you've filled all the fields with valid information. Thank you.", 'warta'); ?>
                                        </div>
                                    <?php elseif($email_sent_error) : ?>
                                        <div class="alert alert-warning">
                                            <?php _e('Oops, something went wrong. Please try again. Thank you.', 'warta') ?>
                                        </div>
                                    <?php elseif($email_sent) : ?>
                                        <div class="alert alert-success">
                                            <?php _e('Your email has been successfully sent. Thank you.', 'warta') ?>
                                        </div>
                                    <?php endif ?>

                                    <form method="post" action="<?php the_permalink(); ?>">
                                        <div class="input-group">
                                            <i class="fa fa-user"></i>
                                            <input type="text" name="contact_name" placeholder="<?php _e('Your full name *', 'warta') ?>" class="input-light <?php if( $error_name ) echo 'input-error' ?>" value="<?php echo $name ?>"  required>
                                        </div>
                                        <div class="input-group">
                                            <i class="fa fa-envelope"></i>
                                            <input type="email" name="contact_email" placeholder="<?php _e('Your email address *', 'warta') ?>" class="input-light <?php if( $error_email ) echo 'input-error' ?>" value="<?php echo $email ?>"  required>
                                        </div>
                                        <div class="input-group">
                                            <i class="fa fa-link"></i>
                                            <input type="url" name="contact_website" placeholder="<?php _e('Your website', 'warta') ?>" value="<?php echo $website ?>" class="input-light">
                                        </div>
                                        <div class="textarea">
                                            <textarea name="contact_message" placeholder="<?php _e('Your message *', 'warta') ?>" class="input-light <?php if( $error_message ) echo 'input-error' ?>" rows="12"  required><?php echo $message ?></textarea>
                                        </div>  
                                        <button type="submit" name="contact_submit" class="btn btn-primary"><?php _e('Send Message', 'warta') ?></button>
                                    </form>

                                </section>

                        </main><!--#main-content-->

                        <?php 
                            /**
                             * Sidebar
                             * -------------------------------------------------------------
                             */
                            $custom_sidebar = get_post_meta( get_the_ID(), '_warta_custom_sidebar', true ); 

                            if( $custom_sidebar ) :
                        ?>

                                <aside class="col-md-4">
                                    <div class="entry-content">
                                        <?php 
                                            $content    = apply_filters('the_content', $custom_sidebar);
                                            $content    = str_replace(']]>', ']]&gt;', $content);

                                            echo $content 
                                        ?>
                                    </div>
                                </aside>

                        <?php else : get_sidebar(); endif; ?>

                </div><!--.row-->
        </div><!--.container-->
</div><!--#content-->

<!-- Google Map API and gmaps.js jQuery plugin -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>        
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/gmaps.js"></script>

<?php get_footer(); ?>