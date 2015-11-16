<?php
/**
 * Template Name: Members Only
 *
 * @package WordPress
 * @subpackage rhd
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( home_url( '/login' ), 301 );
	exit;
}

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			<div class="image-strip"></div>
			
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>