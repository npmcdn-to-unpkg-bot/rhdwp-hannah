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

				<?php rhd_subcat_grid( 'projects' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>