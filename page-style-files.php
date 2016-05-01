<?php
/**
 * The "Style Files" template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content page-style-files">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile ?>

			<?php endif; ?>

			<?php
			$cat = get_cat_ID( 'Style Files' );
			$cat_args = array(
				'type'			=> 'post',
				'child_of'		=> $cat,
				'taxonomy'		=> 'category',
				'hide_empty'	=> 1,
				'orderby'		=> 'term_order',
				'hide_empty'	=> true
			);
			$cats = get_categories( $cat_args );
			?>

			<?php
			// Child Categories
			foreach ( $cats as $cat ) {
				$args = array(
					'cat'			=> $cat->term_id,
					'category__in'	=> null,
					'posts_per_page'=> 6
				);

				$cat_link = get_category_link( $cat->term_id );

				$q_sub = new WP_Query( $args );
				?>

				<?php
				if ( $q_sub->have_posts() ) {
					?>
					<div class="post-grid-wrapper cat-child cat-<?php echo $cat->term_id; ?>">
						<h2 class="sub-cat-title">
							<a href="<?php echo $cat_link; ?>" rel="bookmark" title="Permalink to Category: <?php echo $cat->name; ?>"><?php echo $cat->name; ?></a>
						</h2>
						<div class="post-grid">
							<?php
							while ( $q_sub->have_posts() ) {
								$q_sub->the_post();

								if ( get_post_format() == 'link' )
									get_template_part( 'content', 'link' );
								else
									get_template_part( 'content', 'archive' );
							}
							?>
						</div>
						<?php rhd_grid_more( $cat_link ); ?>
					</div>
					<?php
				}
			}
			?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>