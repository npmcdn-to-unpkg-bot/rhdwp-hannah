<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content">

	<h2 class="page-title"><?php the_title(); ?></h2>

	<?php if ( $_SESSION['blog_area'] === true ) get_template_part( 'module', 'metabar' ); ?>

	<?php
	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	if ( $paged != 1 ) get_template_part( 'module', 'metabar' );
	?>

	<div id="content" role="main">
		<?php
		$i = 0;

		$args = array(
			'post_status' => 'publish',
			'post__in' => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1,
			'paged' => $paged,
			'_is_blog_loop' => true
		);

		$q = new WP_Query( $args );

		if ( RHD_AJAX_PAGINATION ) {
			$data_ajax = array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'query_vars' => json_encode( $q->query )
			);
			wp_localize_script( 'rhd-ajax', 'wp_custom_data', $data_ajax );
		}
		?>

		<?php if ( $q->have_posts() ) : ?>

			<div class="blog-container">
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

	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>