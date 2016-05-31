<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<div id="content" role="main">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="projects-content">
				<?php the_content(); ?>
				
				<?php
				$args = array(
					'post_type' => 'project',
					'posts_per_page' => -1	
				);
				
				$q = new WP_Query( $args );
				?>
				
				<?php if ( $q->have_posts() ) : ?>
					<ul class="projects-grid">
					<?php while ( $q->have_posts() ) : $q->the_post(); ?>
						
						<li class="project-item">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'square' ); ?></a>
						</li>
					
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>
			</div>

		<?php endwhile; ?>

	<?php endif; ?>

</div><!-- #content -->

<?php get_footer(); ?>