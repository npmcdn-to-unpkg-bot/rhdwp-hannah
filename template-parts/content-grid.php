<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php // $class = ( is_archive() || is_search() ) ? 'archive-excerpt' : ''; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'square' ); ?></a>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<p class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></p>
	</header><!-- .entry-header -->
</article><!-- #post -->
