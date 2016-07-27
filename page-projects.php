<?php
/**
 * The "Projects" page template file.
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
				// "Projects" main category grid
				rhd_print_subcat_grid( new WP_Query( 'post_type=post&posts_per_page=6&category_name=projects' ), get_category_by_slug( 'projects' ), 'projects', 'Recent Projects' );
				?>

				<?php
				// "Projects" child category grid
				rhd_subcat_grid( 'projects' );
				?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>