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

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php
				$args = array(
					'post_type' => 'post',
					'category_name' => 'book'
				);
				$q = new WP_Query( $args );
				?>
				<?php if ( $q->have_posts() ) : ?>
					<hr />
					<div class="post-grid book-category-grid">
						<?php while ( $q->have_posts() ) : $q->the_post(); ?>
							<?php get_template_part( 'template-parts/content', 'grid' ); ?>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
