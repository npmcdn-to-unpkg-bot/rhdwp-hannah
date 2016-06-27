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
	
	<aside id="instagram">
		<!-- INSTAGRABBY -->
		<div class="chicken">
			<img src="<?php echo RHD_UPLOAD_URL; ?>/2016/06/chicken.png" alt="chicken">
		</div>
	</aside>

    <footer id="colophon">
        <?php get_sidebar( 'footer' ); ?>
        <div class="site-info">
			<p>
				<?php echo '&copy;' . date( 'Y' ); ?> <?php echo bloginfo( 'name' ); ?> <?php echo ( rhd_is_mobile() ) ? '<br>' : '&bull;'; ?> Branding by <a href="http://www.minted.com/store/toribeedesign" target="_blank">Tori Bee Design</a> <?php echo ( rhd_is_mobile() ) ? '<br>' : '&bull;'; ?> Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse Designs</a>
            </p>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
