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
		</div><!-- .main-inner -->

		<?php if ( is_front_page() ) : ?>
			</div><!-- .border-inner -->
		<?php endif; ?>

	</main><!-- #main -->

	<?php if ( is_front_page() ) : ?>
		<?php rhd_front_page_instagram(); ?>
	<?php endif; ?>

	<footer id="colophon">
		<div class="footer-inner">
			<?php get_sidebar( 'footer' ); ?>

			<div class="site-info">
				<a href="<?php echo home_url(); ?>"><img src="<?php echo RHD_UPLOAD_URL; ?>/2016/05/copper-dot-logo-short.png" alt="Copper Dot Interiors"></a>
				<p>
					<?php echo '&copy;' . date( 'Y' ); ?> Karen Goodman<br />
					Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse<img id="rhd-logo-footer" src="//assets.roundhouse-designs.com/images/rhd-white-house.png" alt="Roundhouse Designs">Designs</a>
				</p>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
