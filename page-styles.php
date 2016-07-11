<?php
/**
 * The "Styles" subcategory grid template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
?>

	<section id="primary" class="site-content full-width">
		<?php while ( have_posts() ) : ?>
			<?php if ( have_posts() ) : the_post(); ?>
				<h2 class="page-title"><?php the_title(); ?></h2>

				<div id="content" role="main">
					<?php rhd_subcat_grid( 'category-styles' ); ?>
				</div><!-- #content -->
			<?php endif; ?>
		<?php endwhile; ?>
	</section><!-- #primary -->

<?php get_footer(); ?>