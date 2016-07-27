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

<aside id="footer-widget-area-left" class="widget-area">
	<?php dynamic_sidebar( 'footer-widget-area' ); ?>
</aside><!-- #footer-widget-area-left -->

<aside id="footer-widget-area-right">
	<?php dynamic_sidebar( 'footer-widget-area-2' ); ?>
</aside><!-- #footer-widget-area-right -->