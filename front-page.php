<?php
/**
 * The Front Page template file.
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

					<?php
					$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
					$args = array(
						'post_type' => 'post',
						'paged' => $paged,
					);
					$news_q = new WP_Query( $args );
					?>

					<?php if ( $news_q->have_posts() ) : ?>
						<div class="grid-container">
							<header class="entry-header">
								<h2 class="page-title">Recent Projects</h2>
							</header>

							<div class="grid-area">
								<?php while ( $news_q->have_posts() ) : $news_q->the_post(); ?>

									<?php get_template_part( 'content', 'grid' ); ?>

								<?php endwhile; ?>
							</div>
						</div>
					<?php endif; ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->

			<?php rhd_archive_pagination( $news_q ); ?>

		</section><!-- #primary -->

<?php get_footer(); ?>