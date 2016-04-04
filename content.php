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
			<?php $external = do_shortcode('[ct id="ct_External_L_text_d664" property="value"]'); ?>
			<?php if ( $external ) : ?>
				<a href="<?php echo $external; ?>" rel="bookmark" target="_blank">
			<?php endif; ?>

			<?php the_post_thumbnail( $thumb_size ); ?>

			<?php if ( $external ) : ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="entry-content">
			<h2 class="entry-title">
				<?php the_title(); ?>
			</h2>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>

			<?php if ( $external ) : ?>
				<div class="ghost-button"><a href="<?php the_permalink(); ?>" target="_blank">Read More</a></div>
			<?php endif; ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	</div>
</article><!-- #post -->
