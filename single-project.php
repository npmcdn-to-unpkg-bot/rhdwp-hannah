<?php
/**
 * The single Project (CPT) template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<div id="secondary" class="single-project-sidebar">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="widget widget-featured-image">
			<?php the_post_thumbnail( 'medium' ); ?>
		</div>
	<?php endif; ?>
</div>

<section id="primary" class="site-content single-project-content">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>
		<?php endif; ?>

	</div><!-- #content -->
</section><!-- #primary -->

<?php get_footer(); ?>