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

<?php if ( is_active_sidebar( 'sidebar-store' ) ) : ?>
	<aside id="secondary" class="widget-area" role="complementary">
		<div class="widget rhd-store-image-widget">
			<?php
			$img_url = do_shortcode('[ct id="ct_Manager_Ph_upload_cd6c" property="value"]');
			$img_cap = do_shortcode('[ct id="ct_Manager_Ph_textarea_a7f1" property="value"]');
			?>
			<?php if ( ! stripos( $img_url, '/media/default.png' ) ) : ?>
				<div class="rhd-store-image">
					<?php echo $img_url; ?>
				</div>

				<?php if ( $img_cap ) : ?>
					<p class="rhd-store-image-caption"><?php echo $img_cap; ?></p>
				<?php endif; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<?php dynamic_sidebar( 'sidebar-store' ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>