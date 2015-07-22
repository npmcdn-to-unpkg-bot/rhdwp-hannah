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

    <footer id="colophon" role="contentinfo">
        <?php get_sidebar( 'footer' ); ?>

        <div id="poly-bl" class="poly">
	        <canvas></canvas>
        </div>
		<div id="poly-br" class="poly">
			<canvas></canvas>
		</div>
    </footer><!-- #colophon -->

    <div id="site-info">
		<p>
			<?php echo '&copy;' . date( 'Y' ); ?> Spear Intellectual Property Law PLC <?php echo ( rhd_is_mobile() ) ? '<br>' : '| '; ?>Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse<img id="rhd-logo-footer" src="//assets.roundhouse-designs.com/images/rhd-black-house.png" alt="Roundhouse Designs">Designs</a>
        </p>
    </div><!-- .site-info -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
