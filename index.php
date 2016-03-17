<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content">

		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content' ); ?>
				<?php endwhile; ?>

			<?php endif; // end have_posts() check ?>

		</div><!-- #content -->

		<?php if ( ! is_single() ) rhd_archive_pagination(); ?>

	</section><!-- #primary -->

<?php get_footer(); ?>
