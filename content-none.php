<?php
/**
 * The default template for displaying static page content.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php
	$thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
?>

	<article id="post-0" class="post no-results not-found">
		<?php if ( current_user_can( 'edit_posts' ) ) :
			// Show a different message to a logged-in user who can add posts.
		?>
			<header class="entry-header">
				<h2 class="entry-title"><?php _e( '404!', 'rhd' ); ?></h2>
			</header>

			<div class="entry-content">
				<p><?php __( 'The page you were looking does not exist, or has moved. Please try a search, or try again.' ); ?></p>
			</div><!-- .entry-content -->

		<?php else :
			// Show the default message to everyone else.
		?>
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'rhd' ); ?></h1>
			</header>

			<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'rhd' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		<?php endif; // end current_user_can() check ?>
	</article><!-- #post-0 -->
