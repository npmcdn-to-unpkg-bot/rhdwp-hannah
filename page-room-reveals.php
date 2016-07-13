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
					'post_type' => 'post',
					'category_name' => 'room-reveals'
				);
				$q = new WP_Query( $args );
				?>

				<?php rhd_post_grid( $q ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>