<?php
/**
 * Template Name: Big Widget Links
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<?php rhd_big_image_widgets(); ?>
	
	<section id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>