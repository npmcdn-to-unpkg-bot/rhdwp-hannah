<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="featured-content">
	<div class="featured-content-slider">
		<img class="logo-overlay" src="<?php echo RHD_IMG_DIR; ?>/logo-full.png" alt="Vintage Revivals">
		<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( 'featured-posts', 'slug' ); } ?>
	</div>
	<div class="featured-links">
		<div class="shop-link">
			<a href="//shop.vintagerevivals.com" rel="prefetch">
				<img src="<?php echo RHD_UPLOAD_URL; ?>/2014/10/vintage_revivals_shop_-copy.jpg" alt="The VR Shop">
			</a>
		</div>
		<div class="featured-single">
			<?php rhd_featured_post(); ?>
		</div>
	</div>
</section>

<section id="primary" class="site-content">
	<div id="content" role="main">
		<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 2,
			'ignore_sticky_posts' => 1,
			'post__in' => get_option( 'sticky_posts' )
		);
		$q = new WP_Query( $args );
		?>
		<?php if ( $q->have_posts() ) : ?>
			<?php while ( $q->have_posts() ) : $q->the_post(); ?>
				<?php get_template_part( 'template-parts/content' ); ?>
			<?php endwhile; ?>
		<?php endif; ?>


	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
