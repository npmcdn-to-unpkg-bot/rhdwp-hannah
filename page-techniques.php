<?php
/**
 * The "Techniques" subcategory grid template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
?>

	<section id="primary" class="site-content full-width">

		<div id="content" role="main">
			<?php rhd_archive_grid( 'techniques' ); ?>
		</div><!-- #content -->

	</section><!-- #primary -->

<?php get_footer(); ?>