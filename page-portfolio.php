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

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php // get_template_part( 'content', 'page' ); ?>

					<?php rhd_portfolio_nav(); ?>

					<div id="rhd-portfolio" class="grid-container">
						<?php $port_query = new WP_Query( 'post_type=portfolio&posts_per_page=-1 ' ); ?>

						<?php if ( $port_query->have_posts() ) : ?>

							<div class="grid-area">

								<?php while ( $port_query->have_posts() ) : $port_query->the_post(); ?>

									<?php get_template_part( 'content', 'portfolio' ); ?>

								<?php endwhile; ?>

							</div>

						<?php endif; ?>

					</div>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>