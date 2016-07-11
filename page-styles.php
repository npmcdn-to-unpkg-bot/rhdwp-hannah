<?php
/**
 * The "Styles" subcategory grid template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
?>

	<section id="primary" class="site-content">

		<div id="content" role="main">
			<?php rhd_archive_grid( 'styles' ); ?>
		</div><!-- #content -->

	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
