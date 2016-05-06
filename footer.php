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
		</div><!-- .main-limiter -->
	</main><!-- #main -->

	<?php if ( is_front_page() ) : ?>
		<?php rhd_front_page_instagram(); ?>
	<?php endif; ?>

    <footer id="colophon">
        <?php get_sidebar( 'footer' ); ?>
        <div class="site-info">
			<p>
				<?php echo '&copy;' . date( 'Y' ); ?> <?php echo bloginfo( 'name' ); ?> <?php echo ( rhd_is_mobile() ) ? '<br>' : '| '; ?>Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse<img id="rhd-logo-footer" src="//assets.roundhouse-designs.com/images/rhd-white-house.png" alt="Roundhouse Designs">Designs</a>
            </p>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
