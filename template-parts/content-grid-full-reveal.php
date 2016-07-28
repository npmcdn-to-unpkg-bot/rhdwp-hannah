<?php
/**
 * The default template for displaying post grid items (full-ratio thumbnails).
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid-item post-grid-item-full' ); ?>>
	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		<?php if ( get_post_type() != 'room-reveal' ) : ?>
			<p class="entry-details"><?php the_time( get_option( 'date_format' ) ); ?></p>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail( 'medium' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-summary">
		<?php rhd_ghost_button( 'Read More', get_the_permalink(), '', 'center', true, true ); ?>
	</div>

	<footer class="entry-meta">
		<p><?php edit_post_link( __( 'Edit Post', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
	</footer><!-- .entry-meta -->
</article><!-- #post -->