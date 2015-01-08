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

	<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>