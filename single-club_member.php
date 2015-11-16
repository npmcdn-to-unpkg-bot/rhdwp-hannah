<?php
/**
 * The Single "Club Member" CPT template file.
 *
 * @package WordPress
 * @subpackage rhd
 */
get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<div id="image-strip">
						<?php the_post_thumbnail( 'medium' ); ?>
					</div>
					
					<?php get_template_part( 'content', 'single-member' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>