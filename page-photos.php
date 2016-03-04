<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>
					
					<?php
					$args = array(
						'post_type' => 'page',
						'post_parent' => 14,
						'posts_per_page' => -1
					);
					
					$photo_q = new WP_Query( $args );
					?>
					
					<?php if ( $photo_q->have_posts() ) : ?>
						
						<div class="post-grid photo-page-grid">
						
							<?php while ( $photo_q->have_posts() ) : $photo_q->the_post(); ?>
								
								<?php get_template_part( 'content', 'photos' ); ?>
							
							<?php endwhile; ?>
						
						</div>
						
					<?php endif; ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>