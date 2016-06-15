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

<?php global $post; ?>

<aside id="secondary" class="widget-area" role="complementary">
	<div id="page-title-mobile" class="widget rhd-static-widget secondary-page-title mobile-only">
		<h2 class="page-title"><?php echo $post->post_title; ?></h2>
	</div>
	
	<div id="page-featured-image" class="widget rhd-static-widget">
		<?php rhd_featured_img( $post->ID, 'large' ); ?>
	</div>
	
	<div id="page-title-large" class="widget rhd-static-widget secondary-page-title large-only">
		<h2 class="page-title"><?php echo $post->post_title; ?></h2>
	</div>
	
	<?php
	if ( is_active_sidebar( 'sidebar' ) )
		dynamic_sidebar( 'sidebar' );
	
	rhd_footer_content( 'desktop' );
	?>
</aside><!-- #secondary -->