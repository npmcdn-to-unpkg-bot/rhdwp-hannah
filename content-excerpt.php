<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'rhd-excerpt-post' ); ?>>
		<div class="post-inner">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<p class="entry-details"><?php  the_time( get_option( 'date_format' ) ); ?><span class="sep"> | </span><span class="entry-cats"><?php the_category( ', ' ); ?></span></p>
			</header><!-- .entry-header -->
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-excerpt-thumbnail">
				<?php the_post_thumbnail( 'square' ); ?>
			</div>
		<?php endif; ?>

		<div class="post-inner">
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

			<footer class="entry-meta">
				<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
			</footer><!-- .entry-meta -->
		</div>
	</article><!-- #post -->