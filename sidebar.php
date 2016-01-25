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
	<aside id="secondary" class="widget-area" role="complementary">
		<h2 class="page-title page-title-sidebar"><?php the_title(); ?></h2>
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>