<?php
/*
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content full-width">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php rhd_full_width_thumbnail( get_post_thumbnail_id() ); ?>

				<?php get_template_part( 'template-parts/content', 'custom-page' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>