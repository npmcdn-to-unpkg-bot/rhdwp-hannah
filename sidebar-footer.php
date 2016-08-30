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

<?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
	<aside id="footer-widget-area" class="widget-area">
		<div class="footer-widgets-left">
			<?php dynamic_sidebar( 'footer-widget-area' ); ?>
		</div>
		<div class="footer-widgets-right">
			<div class="widget rhd-hard-widget">
				<h2 class="widget-title">Ayesh Law Offices</h2>
				<?php rhd_ayesh_address( true ); ?>
				<?php echo do_shortcode( '[map id="1" is_responsive="yes" width="400" height="270"]' ); ?>
			</div>
			<?php dynamic_sidebar( 'footer-widget-area-2' ); ?>
		</div>
	</aside>
<?php endif; ?>
