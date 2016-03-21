<?php
/**
 * The Composer template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="page-image-header">
			<?php the_post_thumbnail( 'full' ); ?>
		</div>
	<?php endif; ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; ?>
			<?php endif; ?>

			<?php
			$args = array(
				'post_type' => 'project',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'project_type',
						'field' => 'slug',
						'terms' => 'composer'
					)
				)
			);
			$composer_q = new WP_Query( $args );
			?>

			<?php if ( $composer_q->have_posts() ) : ?>

				<div id="projects-composer" class="projects-grid-container">
					<ul class="projects-grid">
						<?php while ( $composer_q->have_posts() ) : $composer_q->the_post(); ?>
							<?php if ( has_post_thumbnail() ) : ?>
								<li class="projects-grid-item">
									<a href="<?php the_permalink(); ?>" rel="bookmark">
										<div class="project-thumbnail">
											<?php the_post_thumbnail( 'square' ); ?>
										</div>
										<div class="project-caption">
											<h3 class="project-title">
												<?php the_title(); ?>
											</h3>
										</div>
									</a>
								</li>
							<?php endif; ?>

						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>