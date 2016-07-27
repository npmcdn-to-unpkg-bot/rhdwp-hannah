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
					'posts_per_page' => -1,
					'orderby' => 'menu_order'
				);
				$q = new WP_Query( $args );
				rhd_post_grid( $q, 'room-reveals across-2', '', 'full-reveal', true );
				?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>