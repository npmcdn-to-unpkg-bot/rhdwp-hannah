<?php
/**
 * The front page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content primary-front-page">
		<div id="content" class="content-front-page" role="main">

			<div class="home-big-img">
				<img alt="Matt Greenberg" src="<?php echo RHD_IMG_DIR; ?>/home-retouched.jpg" alt="Matt Greenberg">
			</div>
			
			<?php
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 3
			);
			$news_q = new WP_Query( $args );
			?>

			<?php if ( $news_q->have_posts() ) : ?>
				<div class="news-grid">
					<?php while ( $news_q->have_posts() ) : $news_q->the_post(); ?>
	
						<?php get_template_part( 'content', 'grid' ); ?>
	
					<?php endwhile; ?>
				</div>
				<div class="ghost-button morenews"><a href="<?php echo home_url( '/news' ); ?>">More News</a></div>
			<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>