<?php
/**
 * The "Archives" page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content full-width">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<div id="archives-content">
						<ul class="archives-list">
							<?php wp_get_archives(); ?>
						</ul>
					</div>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>