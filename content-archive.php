<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'archive' );
			} else {
				$updir = wp_upload_dir();
				?>
				<img src="<?php echo $updir['baseurl']; ?>/2015/10/fallback.jpg" alt="Centsational Girl default">
				<?php
			}
			?>
			<h2 class="entry-title"><?php the_title(); ?></h2>
		</a>
	</div><!-- .entry-header -->
</article><!-- #post -->
