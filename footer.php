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
			<div class="footer-inner">
				<div class="social">
					<?php echo do_shortcode( '[rhd-social-icons shape="circle" color1="#1b6992" color2="#8aa442" widget_loc="footer"]' ); ?>
				</div>

				<div class="newsletter">
					<?php echo do_shortcode( '[rhd-mailchimp title="Join Our Newsletter" fname=true lname=true button="subscribe"]' ); ?>
				</div>

				<div class="site-info">
					<p>All our materials are proudly made in the USA.
						<ul class="footer-links">
							<li><a href="<?php echo home_url( '/return-policy' ); ?>">Return Policy</a></li>
							<li><a href="<?php echo home_url( '/privacy-policy' ); ?>">Privacy Policy</a></li>
							<li><a href="<?php echo home_url( '/ordering-shipping-info' ); ?>">Ordering &amp; Shipping Info</a></li>
							<li><a href="<?php echo home_url( '/' ); ?>">Download PDF Order Form</a></li>
						</ul>
					</p>
				</div>
			</div>
			<div class="bottom-stripe">
				<p class="copy">
				<?php echo '&copy;' . date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php echo bloginfo( 'name' ); ?></a> | All Rights Reserved <?php echo wp_is_mobile() ? '<br>' : '|'; ?> Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse Designs</a>
				</p>
			</div>
		</footer>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
