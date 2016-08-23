<?php
/**
 * The default template for displaying grid post items.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid-item' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'square' ); ?>
				<header class="entry-header">
					<h2 class="entry-title">
						<?php the_title(); ?>
					</h2>
				</header><!-- .entry-header -->
			</a>
		</div>
	<?php endif; ?>
</article><!-- #post -->
