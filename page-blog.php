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
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$i = 0; // Post counter

		$args = array(
			'post__in' => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1,
			'posts_per_page' => get_option( 'posts_per_page' ),
			'paged' => $paged
		);
		$q = new WP_Query( $args );
		?>

		<?php if ( $q->have_posts() ) : ?>
			<div class="blog-container blog-area-page<?php echo $paged; ?>">
				<?php while ( $q->have_posts() ) : $q->the_post(); ?>
					<?php
					++$i;
					if ( $i == 1 && $paged == 1 )
						get_template_part( 'content', 'full' );
					else
						get_template_part( 'content', 'excerpt' );
					?>
				<?php endwhile; ?>
			</div>

			<?php rhd_archive_pagination( $q ); ?>
			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

	</div><!-- #content -->
</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>