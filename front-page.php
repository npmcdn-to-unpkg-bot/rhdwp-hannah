<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
$paged = get_query_var( 'paged' );
?>

<section id="primary" class="site-content">
	<div id="content" role="main">

		<?php if ( ! is_paged() ) : // For true page 1 ?>
			<div id="features">
				<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '4610' ); } ?>
			</div>

			<?php $first = new WP_Query( 'posts_per_page=1&ignore_sticky_posts=true' ); ?>
			<?php if ( $first->have_posts() ) : ?>
				<?php while ( $first->have_posts() ) : $first->the_post(); ?>
					<?php $latest = array( get_the_id() ); ?>
					<div class="first-post">
						<?php get_template_part( 'template-parts/content', 'home' ); ?>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ++$i; ?>
				<?php if ( $i === 1 ) : ?>
					<div class="front-page-posts post-grid">
				<?php endif; ?>

				<?php get_template_part( 'template-parts/content', 'excerpt' ); ?>

				<?php if ( rhd_is_last_post() ) : ?>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>

			<?php
			if ( function_exists( 'wp_pagenavi' ) )
				wp_pagenavi();
			else
				rhd_single_pagination();
			?>
		<?php endif; ?>

	</div><!-- #content -->

</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
