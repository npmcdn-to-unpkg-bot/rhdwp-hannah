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
						'post_type' => 'team_member',
						'posts_per_page' => -1
					);
					
					$team_q = new WP_Query( $args );
					?>
					
					<?php if ( $team_q->have_posts() ) : ?>
						
						<div class="post-grid team-page-grid">
						
							<?php while ( $team_q->have_posts() ) : $team_q->the_post(); ?>
								
								<?php get_template_part( 'content', 'team' ); ?>
							
							<?php endwhile; ?>
						
						</div>
						
					<?php endif; ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>