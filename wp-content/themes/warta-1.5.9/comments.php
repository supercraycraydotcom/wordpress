<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to warta_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Warta
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}


/**
 * HTML comment list class.
 *
 * @package Warta
 * @uses Walker_Comment
 */
class Warta_Walker_Comment extends Walker_Comment {
        /**
	 * Start the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 2.7.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of comment.
	 * @param array $args Uses 'style' argument for type of HTML list.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
                $output .= '<ol ' . ( $depth % 2 == 1 ? '' : 'class="children"' ) . '>' . "\n";
            
		$GLOBALS['comment_depth'] = $depth + 1;
	}    
}
?>

<section class="widget" id="comments">

    <?php if ( have_comments() ) : ?>
    
        <!--Header-->
        <header class="clearfix"><h4><?php _e('Comments', 'warta') ?></h4></header>

<?php   if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
                <nav class="page-links" role="navigation">      
<?php                   _ex('Pages: ', 'Comment pages', 'warta'); 
                        paginate_comments_links('prev_text=<i class="fa fa fa-angle-double-'. (is_rtl() ? 'right' : 'left') .'"></i>&next_text=<i class="fa fa fa-angle-double-'. (is_rtl() ? 'left' : 'right') .'"></i>'); ?>
                </nav><!-- .page-links -->
<?php   endif; // check for comment navigation ?>

        <ol class="post-comments">
                <?php
                        /* Loop through and list the comments. Tell wp_list_comments()
                         * to use warta_comment() to format the comments.
                         * If you want to override this in a child theme, then you can
                         * define warta_comment() and that will be used instead.
                         * See warta_comment() in inc/template-tags.php for more.
                         */
                        wp_list_comments( array( 
                            'walker'            => new Warta_Walker_Comment(),
                            'callback'          => 'warta_comment', 
                            'style'             => 'ol',
                            'avatar_size'       => 65,
                            'max_depth'         => 4
                        ) );
                ?>
        </ol><!-- .post-comments -->

<?php   if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
                <nav class="page-links" role="navigation">      
<?php                   _ex('Pages: ', 'Comment pages', 'warta'); 
                        paginate_comments_links('prev_text=<i class="fa fa fa-angle-double-'. (is_rtl() ? 'right' : 'left') .'"></i>&next_text=<i class="fa fa fa-angle-double-'. (is_rtl() ? 'left' : 'right') .'"></i>'); ?>
                </nav><!-- .page-links -->
<?php   endif; // check for comment navigation ?>

    <?php endif; // have_comments() ?>

    <?php
            // If comments are closed and there are comments, let's leave a little note, shall we?
            if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
            <p class="no-comments"><?php _e( 'Comments are closed.', 'warta' ); ?></p>
    <?php endif; ?>

    <?php comment_form(array(
        'fields'        => apply_filters( 'comment_form_default_fields', array(
                        'author'    =>
                            '<div class="input-group"><i class="fa fa-user"></i>' .
                            '<input id="author" name="author" type="text" class="input-light" value="' . esc_attr( $commenter['comment_author'] ) .
                            '" size="30" placeholder="' . __('Your full name', 'warta') . ( $req ? ' *' : '' ) . '" ' . ( $req ? 'required' : '' ) . ' /></div>',

                        'email'     =>
                            '<div class="input-group"><i class="fa fa-envelope"></i>' .
                            '<input id="email" name="email" type="text" class="input-light" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                            '" size="30" placeholder="' . __('Your email address', 'warta') . ( $req ? ' *' : '' ) . '" ' . ( $req ? 'required' : '' ) . ' /></div>',

                        'url'       =>
                            '<div class="input-group"><i class="fa fa-link"></i>' .
                            '<input id="url" name="url" type="text" class="input-light" value="' . esc_attr( $commenter['comment_author_url'] ) .
                            '" size="30" placeholder="' . __('Your website', 'warta') . '" /></div>'
                        )                
        ),
        'comment_field' =>  '<div class="textarea">' . 
                        '<textarea id="comment" name="comment" class="input-light" placeholder="' . __('Your comment *', 'warta') . '" rows="12" aria-required="true" required>' .
                        '</textarea></div>',
    )); ?>

</section><!-- .widget-->
