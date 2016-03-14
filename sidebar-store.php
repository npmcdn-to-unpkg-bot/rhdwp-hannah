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

<?php
//$addr = do_shortcode( '[ct id="ct_Address_textarea_e4cb" property="value"]' );
global $addr;
$addr_min = str_replace( array("\r", "\n"), "", $addr );
?>

<?php if ( is_active_sidebar( 'sidebar-store' ) ) : ?>
	<aside id="secondary" class="widget-area" role="complementary">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="widget rhd-store-header-image">
				<div class="single-store-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="widget rhd-store-map">
			<div class="single-store-map">
				<?php echo do_shortcode( "[pw_map width='100%' height='300px' address='$addr_min']" ); ?>
				<div class="single-store-map-caption">
					<?php echo wpautop( $addr ); ?>
				</div>
			</div>
		</div>

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