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
				<?php echo rhd_site_branding( 'icon', 'medium', 'footer-social' ); ?>
				<?php echo do_shortcode( '[rhd-social-icons shape="circle" color1="#ffffff" color2="#0077c0" widget_loc="footer"]' ); ?>
	        </div>

	        <div class="newsletter">
				<?php echo do_shortcode( '[rhd-mailchimp title="Join Our Newsletter" fname=true lname=true button="subscribe"]' ); ?>
	        </div>

	        <div class="site-info">
				<p>
					<?php echo '&copy;' . date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php echo bloginfo( 'name' ); ?></a> &amp;<br />
					<a href="http://www.stanislauscommunityfoundation.org">Stanislaus Community Foundation</a><br />
					<br />
					<a href="<?php echo home_url( '/privacy-policy' ); ?>" rel="bookmark">Privacy Policy</a> | <a href="<?php echo home_url( 'terms' ); ?>" rel="bookmark">Terms &amp; Conditions</a><br />
					<br />
					Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse Designs</a>
	            </p>
	        </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
