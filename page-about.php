<?php
/**
 * The "About" static page template.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<div class="about-sidebar">
						<div class="entry-header">
							<h2 class="page-title page-title-sidebar"><?php the_title(); ?></h2>
						</div>

						<?php $img = wp_get_attachment_image_src( 478, 'medium_large', false ); ?>
						<img src="<?php echo $img[0]; ?>" alt="Vanessa Leuck and subway train">
					</div>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>