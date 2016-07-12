<?php
/**
 * The default template for displaying post grid items (full-ratio thumbnails).
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid-item post-grid-item-full' ); ?> data-expanded="false">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'medium' ); ?></a>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-meta">
		<p><?php edit_post_link( __( 'Edit Post', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
	</footer><!-- .entry-meta -->
</article><!-- #post -->