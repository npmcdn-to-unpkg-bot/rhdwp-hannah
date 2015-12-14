<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
$updir = wp_upload_dir();
?>

	<aside id="highlights">
		<figure class="highlight-link">
			<a href="<?php echo home_url('/recent-events'); ?>">
				<?php $img_1 = wp_get_attachment_image_src( 78459, '4x6' ); ?>
				<img src="<?php echo $img_1[0]; ?>" alt="Recent Events">
				<figcaption>Recent Events</figcaption>
			</a>
		</figure>
		
		<figure class="highlight-link">
			<a href="<?php echo home_url('/about/become-a-member'); ?>">
				<?php $img_3 = wp_get_attachment_image_src( 78461, '4x6' ); ?>
				<img src="<?php echo $img_3[0]; ?>" alt="Become a Member">
				<figcaption>Become a Member</figcaption>
			</a>
		</figure>
		
		<figure class="highlight-link">
			<a href="<?php echo home_url('/donate'); ?>">
				<?php $img_2 = wp_get_attachment_image_src( 57, '4x6' ); ?>
				<img src="<?php echo $img_2[0]; ?>" alt="Donate to The Lambs">
				<figcaption>Donate to The Lambs</figcaption>
			</a>
		</figure>
	</aside>
	
	<section id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>