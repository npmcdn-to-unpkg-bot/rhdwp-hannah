<?php
/*
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content full-width">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php rhd_full_width_thumbnail( get_post_thumbnail_id() ); ?>

				<?php get_template_part( 'template-parts/content', 'full-width' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

		<?php if ( $post->post_name == 'students' || $post->post_name == 'donors' ) rhd_grid_feed( $post->post_name ); ?>

		<div class="entry-meta">
			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</div>
	</div>
</section>

<?php get_footer(); ?>