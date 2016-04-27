<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content full-width">
		<div id="content" role="main">
			<section id="front-page-slideshow" class="full-width-slideshow">
				<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '130' ); } ?>
			</section>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'no-title' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>