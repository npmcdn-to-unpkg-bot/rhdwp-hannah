<?php
/**
 * The default template for displaying external link posts. Used for post format "link" and for CPT "Shop"
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php
$link = ( get_post_type() == 'shop' ) ? do_shortcode( '[ct id="_ct_text_562e71e877582" property="value"]' ) : esc_url( get_the_content() );
$text = get_the_title();

error_log($link);
?>

<?php
// Redirect if we're at a single post page
if ( is_single() ) {
	wp_redirect( $link, 301 );
	exit;
}
?>

<?php if ( $link != home_url() && $text ) : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-linked post' ); ?>>
		<div class="entry-thumbnail">
			<a href="<?php echo $link; ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark" target="_blank">
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

<?php endif; ?>