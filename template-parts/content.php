<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php $ext_link = do_shortcode( '[ct id="_ct_text_574dfe5c8c82c" property="value"]' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title">
			<?php if ( $ext_link ) : ?>
				<a href="<?php echo $ext_link; ?>" target="_blank">
					<?php the_title(); ?>
				</a>
			<?php else : ?>
				<?php the_title(); ?>
			<?php endif; ?>
		</h2>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php if ( ! is_single() && has_post_thumbnail() ) : ?>
				<?php if ( $ext_link ) : ?>
					<a href="<?php echo $ext_link; ?>" target="_blank">
						<?php the_post_thumbnail( 'large' ); ?>
					</a>
				<?php else : ?>
					<?php the_post_thumbnail( 'large' ); ?>
				<?php endif; ?>
			<?php endif; ?>
				
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>

		</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
	</footer><!-- .entry-meta -->
</article><!-- #post -->