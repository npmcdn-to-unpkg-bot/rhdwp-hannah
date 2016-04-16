<?php
/**
 * The Music Director template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="page-header-image">
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
			);
			$projects_q = new WP_Query( $args );
			?>

			<?php if ( $projects_q->have_posts() ) : ?>

				<div id="projects-music-director" class="projects-grid-container">
					<ul class="projects-grid">
						<?php while ( $projects_q->have_posts() ) : $projects_q->the_post(); ?>
							<?php if ( has_post_thumbnail() ) : ?>
								<li class="projects-grid-item">
									<div class="project-thumbnail">
										<a href="<?php the_permalink(); ?>" rel="bookmark">
											<?php the_post_thumbnail( 'square' ); ?>
										</a>
									</div>
									<div class="project-caption">
										<h3 class="project-title">
											<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
										</h3>
									</div>
								</li>
							<?php endif; ?>

						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>