<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'recent-post' ); ?>>
		<header class="entry-header">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
				<div class="recent-post-thumbnail">
					<?php the_post_thumbnail( 'square' ); ?>
				</div>
				<h2 class="entry-title ff-courier">
					<?php the_title(); ?>
				</h2>
			</a>
		</header><!-- .entry-header -->

		<footer class="entry-meta">
			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
