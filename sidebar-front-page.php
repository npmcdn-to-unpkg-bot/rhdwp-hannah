<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php if ( is_active_sidebar( 'front-page-widget-area' ) ) : ?>
	<aside id="front-page-widget-area" class="widget-area">
		<?php dynamic_sidebar( 'front-page-widget-area' ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>
