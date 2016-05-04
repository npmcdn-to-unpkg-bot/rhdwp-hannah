<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content full-width">
	<div id="content" class="border-inner" role="main">

		<div id="front-page-recent-posts" class="blog-area">
			<div class="border-inner">
				<h3 class="section-title">Recent Posts</h3>
				<?php
				$args = array(
					'posts_per_page' => 3,
					'post_status' => 'publish'
				);
				$recent_q = new WP_Query( $args );
				?>
				<?php if ( $recent_q->have_posts() ) : ?>
					<div class="front-page-posts">
						<?php while ( $recent_q->have_posts() ) : $recent_q->the_post(); ?>
							<?php get_template_part( 'content', 'excerpt' ); ?>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div><!-- #content -->
</section><!-- #primary -->

<?php get_footer(); ?>