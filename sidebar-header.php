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

<?php if ( is_active_sidebar( 'header-widget-area' ) ) : ?>
	<aside id="header-widget-area" class="widget-area">
		<?php dynamic_sidebar( 'header-widget-area' ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>
