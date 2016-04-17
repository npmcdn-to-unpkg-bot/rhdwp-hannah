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

<?php if ( is_active_sidebar( 'sidebar-project' ) ) : ?>
	<section id="secondary" class="single-project-sidebar widget-area">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="widget widget-featured-image">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		<?php endif; ?>
		
		<?php dynamic_sidebar( 'sidebar-project' ); ?>
	</section><!-- #sidebar-project -->
<?php endif; ?>
