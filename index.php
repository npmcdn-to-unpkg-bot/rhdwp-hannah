<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
session_start();
?>

	<section id="primary" class="site-content">
		<?php if ( $_SESSION['blog_area'] === true ) get_template_part( 'module', 'metabar' ); ?>

		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content' ); ?>
				<?php endwhile; ?>

			<?php endif; // end have_posts() check ?>

		</div><!-- #content -->

		<?php rhd_archive_pagination(); ?>

	</section><!-- #primary -->

<?php get_footer(); ?>
