<?php
/**
 * Template Name: Image Feature Page
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content image-feature-template">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div><!-- #content -->
</section><!-- #primary -->

<?php if ( has_post_thumbnail() ) : ?>
	<?php
	$thumb_id = get_post_thumbnail_id();
	$thumb = wp_get_attachment_image_src( $thumb_id, 'full', true );
	?>
	<section id="secondary" class="image-feature" style="background-image: url(<?php echo $thumb[0]; ?>);">
	</section>
<?php endif; ?>

<?php get_footer(); ?>