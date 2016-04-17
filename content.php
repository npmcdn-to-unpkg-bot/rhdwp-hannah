<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php
if ( is_front_page() ) {
	$class = 'news-grid-item';
	$thumb_size = 'square';
} else {
	$class = 'news-item';
	$thumb_size = 'large';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<div class="news-item-inner">
		<div class="post-featured-image">
			<?php $ext = do_shortcode('[ct id="ct_External_L_text_d664" property="value"]'); ?>
			<?php if ( $ext ) : ?>
				<a href="<?php echo $ext; ?>" rel="bookmark" target="_blank">
			<?php endif; ?>

			<?php the_post_thumbnail( $thumb_size ); ?>

			<?php if ( $ext ) : ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="entry-content">
			<h2 class="entry-title">
				<?php if ( $ext ) : ?>
					<a href="<?php echo $ext; ?>">
				<?php endif; ?>

					<?php the_title(); ?>

				<?php if ( $ext ) : ?>
					</a>
				<?php endif; ?>
			</h2>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>

			<?php if ( $ext ) : ?>
				<div class="ghost-button"><a href="<?php echo $ext; ?>" target="_blank">Read More</a></div>
			<?php endif; ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	</div>
</article><!-- #post -->
