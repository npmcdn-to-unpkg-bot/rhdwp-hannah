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
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php the_post_thumbnail( 'square' ); ?>
			<figcaption class="entry-title">
				<?php the_title(); ?>
			</figcaption>
		</a>
	</figure>
</article>
