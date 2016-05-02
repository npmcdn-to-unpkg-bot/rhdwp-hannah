<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'donation-main-content' ); ?>>
	<div class="post-inner">
		<header class="entry-header">
			<h2 class="page-title">
				<?php the_title(); ?>
			</h2>
		</header><!-- .entry-header -->

		<?php if ( has_post_thumbnail() && ! rhd_donate_has_full_header() ) : ?>
			<div class="donation-page-thumbnail">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
	</div>

	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->