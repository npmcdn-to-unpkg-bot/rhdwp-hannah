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
			'post_type' => 'post',
			'posts_per_page' => 4,
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
