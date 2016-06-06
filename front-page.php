<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content full-width">
	<div id="content" role="main">

		<section id="front-page-features">
			
		</section>

		<section id="front-page-intro">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="intro-thumbnail">
							<?php rhd_picture_frame( get_the_post_thumbnail( get_the_id(), 'large' ), 'intro-image' ); ?>
						</div>
					<?php endif ;?>
					
					<div class="intro-content-container">
						<div class="intro-hi">Hi!</div>
						<div class="intro-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
						</div>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</section>
		
		<hr class="goldsep">
		
		<section id="front-page-categories">
			<h2 class="section-title">what are you looking for?</h2>
			
			<?php rhd_featured_categories( 'front-page' ); ?>
		</section>
		
		<hr class="goldsep">
		
		<section id="front-page-video">
			<?php if ( function_exists( 'soliloquy' ) ) soliloquy( 'front-page-video', 'slug' ); ?>
		</section>
		
		<hr class="goldsep">
		
		<section id="front-page-posts">
			<?php
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'post_status' => 'publish'
			);
			
			$fpq = new WP_Query( $args );
			?>
			
			<?php if ( $fpq->have_posts() ) : ?>
				<div class="rhd-recent-posts">
					<?php while ( $fpq->have_posts() ) : $fpq->the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'recent' ); ?>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</section>

	</div>
</section>

<?php get_footer(); ?>