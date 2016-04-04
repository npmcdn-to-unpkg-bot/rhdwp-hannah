<?php
/**
 * The Front Page main template file.
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
			<h2 class="page-title"><?php the_title(); ?></h2>
			<?php
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 3
			);
			$news_q = new WP_Query( $args );
			?>

			<?php if ( $news_q->have_posts() ) : ?>
				<?php while ( $news_q->have_posts() ) : $news_q->the_post(); ?>

					<div class="news-grid">
						<?php get_template_part( 'content', 'grid' ); ?>
					</div>

				<?php endwhile; ?>
			<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>