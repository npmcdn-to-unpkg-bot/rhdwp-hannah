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
								<?php $href = do_shortcode('[ct id="_ct_text_56eaf99828c97" property="value"]'); ?>

								<li class="projects-grid-item">
									<?php if ( $href ) : ?>
										<a href="<?php echo $href; ?>" target="_blank">
									<?php endif; ?>
									<div class="project-thumbnail">
										<?php the_post_thumbnail( 'square' ); ?>
									</div>
									<div class="project-caption">
										<h3 class="project-title">
											<?php the_title(); ?>
										</h3>
										<div class="project-details">
											<?php the_content(); ?>
										</div>
									</div>
									<?php if ( $href ) : ?>
										</a>
									<?php endif; ?>
								</li>
							<?php endif; ?>

						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>