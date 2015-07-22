<?php
/**
 * The "About" Widget Area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php if ( is_active_sidebar( 'about-widget-area' ) ) : ?>
	<aside id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'about-widget-area' ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>