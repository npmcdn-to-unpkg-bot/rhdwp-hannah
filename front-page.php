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
					<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</section>
		
		<hr class="goldsep">
		
		<section id="front-page-sections">
			<h2 class="section-title">what are you looking for?</h2>
		</section>
		
		<hr class="goldsep">
		
		<section id="front-page-video">
			
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