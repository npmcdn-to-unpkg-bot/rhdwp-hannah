<?php
/**
 * The front page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();

$paged = get_query_var( 'paged' );
?>

	<section id="primary" class="site-content">
		<?php
		if ( function_exists( 'soliloquy' ) && $paged == 0 )
			soliloquy( 'home-page-slider', 'slug' );
		?>

		<div id="content" role="main">

			<?php
			$args = array(
				'post_type'			=> 'post',
				'post_status'		=> 'publish',
				'posts_per_page'	=> 2,
				'paged'				=> $paged,
				'tax_query'			=> array(
					array(
						'taxonomy'		=> 'post_format',
						'field'			=> 'slug',
						'terms'			=> array( 'post-format-link' ),
						'operator'		=> 'NOT IN'
					)
				)
			);
			$q = new WP_Query( $args );
			?>

			<?php if ( $q->have_posts() ) : ?>

				<?php while ( $q->have_posts() ) : $q->the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->

			<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi( array( 'query' => $q ) ); ?>

		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>