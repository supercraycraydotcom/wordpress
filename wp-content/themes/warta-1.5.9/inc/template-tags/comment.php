<?php
/**
 * Template for comments and pingbacks
 * 
 * @package Warta
 */

if ( ! function_exists( 'warta_comment' ) ) :
/**
 * Template for comments and pingbacks.
 * 
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function warta_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
        
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-pingback-trackback">
			<?php _e( 'Pingback:', 'warta' ); ?> <?php comment_author_link(); ?>
                        <p class="comment-meta">                        
                                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                                    <i class="fa fa-clock-o"></i> 
                                    <time datetime="<?php comment_time( 'c' ); ?>">
                                        <?php echo sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'warta' ), get_comment_date(), get_comment_time() ); ?>
                                    </time>
                                </a> &nbsp;

                                <?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
                                    <a href="<?php echo get_edit_comment_link( $comment->comment_ID ) ?>"><i class="fa fa-pencil"></i> <?php echo __( 'Edit', 'warta' ) ?></a>
                                <?php endif ?>
                        </p>  
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
            
            <div class="comment-container">
                
                <?php if( $depth % 2 == 1 ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
                
                <div class="content">
                    <p class="comment-meta">
                        <a <?php if( get_comment_author_url() ) : ?> href="<?php echo get_comment_author_url() ?>" <?php endif ?> class="bypostauthor">
                            <i class="fa fa-user"></i> <?php echo get_comment_author() ?>
                        </a> &nbsp;
                        
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <i class="fa fa-clock-o"></i> 
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php echo sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'warta' ), get_comment_date(), get_comment_time() ); ?>
                            </time>
                        </a> &nbsp;
                        
                        <?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
                            <a href="<?php echo get_edit_comment_link( $comment->comment_ID ) ?>"><i class="fa fa-pencil"></i> <?php echo __( 'Edit', 'warta' ) ?></a>
                        <?php endif ?>
                    </p>   
                    <?php
                        comment_reply_link( array_merge( $args, array(
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'        => '<div class="reply">',
                            'after'         => '</div>',
                            'reply_text'    => '<i class="fa fa-reply"></i> ' . __('Reply', 'warta')
                        ) ) );
                    ?>
                    <div class="comment">
                        <?php comment_text(); ?>
                                
                        <i class="triangle"></i>
                    </div>
                    
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                        <small><em><?php _e( 'Your comment is awaiting moderation.', 'warta' ); ?></em></small>
                    <?php endif; ?>
                </div>
                
                <?php if( $depth % 2 == 0 ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
                
            </div><!--.comment-container-->
            
	<?php
	endif;
}
endif; // ends check for warta_comment()