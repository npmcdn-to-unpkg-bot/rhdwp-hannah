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
        </div><!-- #main .wrapper -->
        <footer id="colophon" role="contentinfo">
                <?php get_sidebar('footer'); ?>
                <div class="site-info">
                        <p>
				<?php echo '&copy;' . date( 'Y' ); ?> <?php echo bloginfo( 'name' ); ?><br>
                                Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse<img id="rhd-logo-footer" src="//assets.roundhouse-designs.com/images/rhd-white-house.png" alt="Roundhouse Designs">Designs
                        </p>
                </div><!-- .site-info -->
        </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
