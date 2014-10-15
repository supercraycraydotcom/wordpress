<?php
/**
 * Display navigation to next/previous post when applicable
 * 
 * @package Warta
 */

if ( ! function_exists( 'warta_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 * 
 * @return void
 */
function warta_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="sr-only"><?php _e( 'Post navigation', 'warta' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">Previous Post:</span> <h5>%title</h5>', 'Previous post link', 'warta' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '<span class="meta-nav">Next Post:</span> <h5>%title</h5>', 'Next post link',     'warta' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif; // warta_post_nav