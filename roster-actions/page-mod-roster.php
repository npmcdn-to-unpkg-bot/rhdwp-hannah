<?php ini_set('max_execution_time', 300); ?>

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

			<?php
			$args = array(
				'post_type' => 'club_member',
				'posts_per_page' => -1
			);
			$q = new WP_Query($args);
			?>
			
			<?php if ( $q->have_posts() ) : ?>
				<?php while ( $q->have_posts() ) : $q->the_post(); ?>
					
					<?php
					if ( ! has_term( '', 'glossary' ) ) {
						$title = get_the_title();
						$ltr = strtolower( $title[0] );
						
						wp_set_object_terms( $post->ID, $ltr, 'glossary' );
					} 
					?>
				
				<?php endwhile; ?>
			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>