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

	</main><!-- #main -->
		<footer id="colophon">
			<div id="footer-widget-area">
				<?php get_sidebar( 'footer' ); ?>
			</div>
			<div id="footer-hheart-logo">
				<?php $updir = wp_upload_dir(); ?>
				<a href="//hospiceheart.org"><img src="<?php echo $updir['baseurl']; ?>/2015/11/Community-Hospice_vertical.png" alt="Community Hospice"></a>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>