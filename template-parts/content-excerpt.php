<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-thumbnail">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'square' ); ?></a>
				</div>
			<?php endif; ?>

			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<p class="entry-details"><?php the_time( get_option( 'date_format' ) ); ?></p>
		</header><!-- .entry-header -->

		<?php if ( ! is_front_page() ) : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<?php rhd_ghost_button( 'Read More', get_the_permalink(), null, 'center', true, true ); ?>
		<?php endif; ?>

		<footer class="entry-meta">
			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
