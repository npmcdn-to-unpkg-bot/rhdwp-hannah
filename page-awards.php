<?php
/**
 * The "Awards" Page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
						
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
			
			<?php rhd_print_awards_table( 'tony', 'Tony Awards' );	?>
				
			<?php rhd_print_awards_table( 'oscar', 'Oscars' ); ?>
				
			<?php rhd_print_awards_table( 'other', 'Other Awards' ); ?>
			
			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>