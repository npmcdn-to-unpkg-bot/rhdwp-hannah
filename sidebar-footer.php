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

<aside id="footer-widget-area" class="widget-area">
	<div id="footer-widget-area-left">
		<?php dynamic_sidebar( 'footer-widget-area-left' ); ?>
		<?php rhd_byline( 'left' ); ?>
	</div>
	<div id="footer-widget-area-right">
		<?php dynamic_sidebar( 'footer-widget-area-right' ); ?>
		<?php rhd_byline( 'right' ); ?>
	</div>
</aside><!-- #secondary -->
