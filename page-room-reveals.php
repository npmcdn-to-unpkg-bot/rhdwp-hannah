<?php
/**
 * The "Room Reveals" page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content full-width">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<header class="page-header">
					<h2 class="page-title"><?php the_title(); ?></h2>
				</header>

				<?php
				$args = array(
					'post_type' => 'room-reveal',
					'posts_per_page' => -1
				);
				$q = new WP_Query( $args );
				?>

				<?php if ( $q->have_posts() ) : ?>
					<div class="post-grid room-reveals-grid">
						<?php while ( $q->have_posts() ) : $q->the_post(); ?>
							<?php get_template_part( 'template-parts/content', 'grid-square' ); ?>
						<?php endwhile; ?>
				<?php endif; ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>