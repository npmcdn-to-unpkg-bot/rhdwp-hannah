<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php
			$args = array(
				'post_type' => 'service',
				'posts_per_page' => -1
			);
			$services_q = new WP_Query( $args );
			?>

			<?php if ( $services_q->have_posts() ) : ?>
				<div id="services-list">
					<?php while ( $services_q->have_posts() ) : $services_q->the_post(); ?>
						<?php get_template_part( 'content', 'services-page' ); ?>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>