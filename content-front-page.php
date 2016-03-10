<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search, as well as home page.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-item' ); ?>>
	<figure class="grid-featured-image">
		<?php $external = esc_url( do_shortcode('[ct id="ct_External_L_text_e6ca" property="value"]') ); ?>
		<?php if ( $external ) : ?>
			<a href="<?php echo $external; ?>" rel="bookmark" target="_blank">
		<?php endif; ?>
				<?php the_post_thumbnail( 'square' ); ?>
				<figcaption class="entry-title">
					<?php the_title(); ?>
				</figcaption>
		<?php if ( $external ) : ?>
			</a>
		<?php endif; ?>
	</figure>
</article>
