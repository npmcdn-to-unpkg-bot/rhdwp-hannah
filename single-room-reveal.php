<?php
/**
 * The single "room-reveal" CPT template file.
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
				<?php get_template_part( 'template-parts/content', 'single' ); ?>
			<?php endwhile; ?>

		<?php endif; // end have_posts() check ?>

		<?php rhd_room_reveal_related_posts(); ?>

	</div><!-- #content -->

</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
