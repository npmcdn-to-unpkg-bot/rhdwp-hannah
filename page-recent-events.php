<?php
/**
 * The "Recent Events" static page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content blog-area blog-area-no-sidebar">
		<div id="content" role="main">
			
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
			
			<?php
			$paged = get_query_var( 'paged' );
			$q = new WP_Query( "category_name=recent-events&paged=$paged" );
			?>
			
			<?php if ( $q->have_posts() ) : ?>
				<?php while ( $q->have_posts() ) : $q->the_post(); ?>
												
					<?php get_template_part( 'content' ); ?>
					
				<?php endwhile; ?>
			<?php endif; ?>

		</div><!-- #content -->
		
		<?php rhd_archive_pagination( $q ); ?>
		
		<?php wp_reset_postdata(); ?>
		
	</section><!-- #primary -->

<?php get_footer(); ?>