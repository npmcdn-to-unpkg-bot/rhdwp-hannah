<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php $thumb = ( has_post_thumbnail() ) ? 'has-post-thumbnail' : ''; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $thumb ); ?>>
	<div class="post-inner">
		<?php if ( ! is_search() && $thumb != '' && is_front_page() ) : ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'square' ); ?>
			</div>
		<?php endif ;?>

		<div class="post-content">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>

				<p class="entry-details"><?php  the_time( get_option( 'date_format' ) ); ?></p>
			</header><!-- .entry-header -->

			<?php if ( $thumb != '' && ! is_front_page() ) : ?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_search() || is_front_page() ) : // Only display Excerpts for Search and Front Pages ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php else : ?>
				<div class="entry-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>

				</div><!-- .entry-content -->
			<?php endif; ?>
		</div>
	</div>

	<?php if ( ! is_front_page() ) : ?>
		<footer class="entry-meta">
			<?php
			if ( ! is_front_page() ) {
				comments_popup_link( 'No Comments', '1 Comment', '% Comments', 'comments-popup', 'Comments are disabled.' );
				rhd_post_meta_links();
			}
			?>
			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	<?php endif; ?>
</article><!-- #post -->