<?php
/**
 * The sidebar containing the front page Featured Content area.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php if ( is_active_sidebar( 'featured-content-area' ) ) : ?>
	<aside id="featured-content" class="widget-area">
		<div class="featured-content-wrapper">
			<?php if( !rhd_is_mobile() ) : ?>
				<div class="featured-content-slider">
					<img class="logo-overlay" src="<?php echo RHD_IMG_DIR; ?>/logo-full.png" alt="Vintage Revivals">
					<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( 'featured-posts', 'slug' ); } ?>
				</div>
			<?php endif; ?>

			<div class="featured-links">
				<?php dynamic_sidebar( 'featured-content-area' ); ?>
			</div>
		</div>
	</aside>
<?php endif; ?>