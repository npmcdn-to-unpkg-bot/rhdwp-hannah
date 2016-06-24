<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php $class = ( is_archive() || is_search() ) ? 'archive-excerpt' : ''; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'square' ); ?></a>
		</div>
	<?php endif; ?>

	<div class="entry-excerpt">
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<?php rhd_entry_header( '<br />' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<footer class="entry-meta">
			<?php if ( ! is_front_page() ) : ?>
				<p class="entry-cats">Filed under: <?php the_category( ', ' ); ?></p>
				<p class="entry-tags"><?php the_tags( 'Tagged with: ', ', ' ); ?></p>
			<?php endif; ?>

			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	</div>
</article><!-- #post -->
