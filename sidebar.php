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
		<div class="sidebar-widget-container">
			<?php $img = wp_get_attachment_image_src( 5, 'full' );  ?>
			<a href="<?php echo home_url(); ?>"><img id="site-title-sidebar" alt="Kelly Bernier Designs" class="site-title" src="<?php echo $img[0]; ?>"></a>

			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div>

		<div id="colophon">
			<p>
				<?php echo '&copy;' . date( 'Y' ); ?> <?php echo bloginfo( 'name' ); ?> <br />
				Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse<img id="rhd-logo-footer" src="//assets.roundhouse-designs.com/images/rhd-black-house.png" alt="Roundhouse Designs">Designs</a>
			</p>
		</div><!-- .site-info -->
	</aside><!-- #secondary -->
<?php endif; ?>