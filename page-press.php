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

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; ?>
			<?php endif; ?>

			<div id="posts-feed">
				<?php
				if ( get_query_var( 'paged' ) )
					$paged = get_query_var( 'paged' );
				else {
					if ( get_query_var( 'page' ) )
					    $paged = get_query_var( 'page' );
					else
						$paged = 1;
				}

				$args = array(
					'category_name' => 'press',
					'paged' => $paged
				);
				$press_q = new WP_Query( $args );
				?>
				<?php if ( $press_q->have_posts() ) : ?>
					<?php while ( $press_q->have_posts() ) : $press_q->the_post(); ?>

						<?php get_template_part( 'content', 'press' ); ?>

					<?php endwhile; ?>
				<?php endif; ?>
				<?php rhd_archive_pagination( $press_q ); ?>
			</div>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>