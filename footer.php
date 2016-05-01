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
        <?php get_sidebar( 'footer' ); ?>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
