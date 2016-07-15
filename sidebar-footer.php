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
		<div class="footer-widget-area-inner">
			<?php dynamic_sidebar( 'footer-widget-area' ); ?>
		</div>
	</aside>
<?php endif; ?>
