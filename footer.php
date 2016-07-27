<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

		<?php if ( ! is_front_page() ) : ?>
			</div><!-- #main-inner -->
		<?php endif; ?>
	</main><!-- #main -->
		<footer id="colophon">
			<div id="footer-widget-area">
				<?php get_sidebar( 'footer' ); ?>
			</div>
			<div id="footer-hheart-logo">
				<?php $updir = wp_upload_dir(); ?>
				<a href="//hospiceheart.org"><img src="<?php echo $updir['baseurl']; ?>/2016/03/Community-Hospice_vertical.png" alt="Community Hospice"></a>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>