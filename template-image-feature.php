<?php
/**
 * Template Name: Image Feature Page
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content image-feature-template">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div><!-- #content -->
</section><!-- #primary -->

<?php if ( has_post_thumbnail() ) : ?>
	<section id="secondary" class="image-feature">
		<div class="page-thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>