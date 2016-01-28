<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search, as well as home page.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-item' ); ?>>
		<div class="news-item-inner">
			<div class="post-featured-image">
				<?php $external = do_shortcode('[ct id="ct_External_L_text_e6ca" property="value"]'); ?>
				<?php if ( $external ) : ?>
					<a href="<?php echo $external; ?>" rel="bookmark" target="_blank">
				<?php endif; ?>

				<?php the_post_thumbnail( 'square' ); ?>

				<?php if ( $external ) : ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="entry-content">
				<h2 class="entry-title">
					<?php the_title(); ?>
				</h2>
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
			</div><!-- .entry-content -->

			<footer class="entry-meta">
				<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
			</footer><!-- .entry-meta -->
		</div>
	</article><!-- #post -->