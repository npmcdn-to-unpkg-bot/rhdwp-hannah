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

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
