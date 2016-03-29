<?php
/**
 * The single Project (CPT) template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<?php $scsc = do_shortcode( '[ct id="_ct_text_56ec60ca79210" property="value"]' ); ?>

<section id="primary" class="site-content single-project-content">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>
		<?php endif; ?>

	</div><!-- #content -->
</section><!-- #primary -->

<div id="secondary" class="soundcloud-sidebar">
	<?php if ( ! empty( $scsc ) ) : ?>
		<div class="widget single-project-soundcloud">
			<h3 class="widget-title">Listen</h3>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="single-project-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<?php
				$scsc = rhd_soundcloud_filter( $scsc );
				echo do_shortcode( $scsc );
			?>
		</div>
	<?php elseif ( has_post_thumbnail() ) : ?>
		<div class="widget widget-featured-image">
			<?php the_post_thumbnail( 'medium' ); ?>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>