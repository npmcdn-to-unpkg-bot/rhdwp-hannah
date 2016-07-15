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
		<div class="footer-signup">
			<?php echo do_shortcode( '[rhd-mailchimp text="Get updates right to your inbox" button="Sign Me Up!"]' ); ?>
		</div>

		<?php get_sidebar( 'footer' ); ?>

		<div class="site-info">
			<p>
				<?php echo '&copy;' . date( 'Y' ); ?> <?php echo bloginfo( 'name' ); ?> <?php echo ( rhd_is_mobile() ) ? '<br>' : '| '; ?>Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse Designs</a>
			</p>
		</div>
	</footer>
	</div><!-- #page -->

	<?php wp_footer(); ?>
	</body>
	</html>
