<?php
/**
 * The "Shop" template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content page-shop">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile ?>

			<?php endif; ?>

			<?php
			$cat_args = array(
				'orderby'		=> 'term_order',
			);
			$cats = get_terms( 'shop_category', $cat_args );
			?>

			<?php
			// Child Categories
			foreach ( $cats as $cat ) {
				$args = array(
					'post_type'		=> 'shop',
					'posts_per_page'=> -1,
					'tax_query' => array(
						array(
							'taxonomy'	=> 'shop_category',
							'field'		=> 'slug',
							'terms'		=> $cat->slug
						)
					)
				);

				$cat_link = get_term_link( $cat );

				$q_sub = new WP_Query( $args );
				?>

				<?php
				if ( $q_sub->have_posts() ) {
					?>
					<div class="post-grid cat-child cat-<?php echo $cat->term_id; ?>">
						<h2 class="sub-cat-title">
							<a href="<?php echo $cat_link; ?>" rel="bookmark" title="Permalink to Category: <?php echo $cat->name; ?>"><?php echo $cat->name; ?></a>
						</h2>

						<?php
						while ( $q_sub->have_posts() ) {
							$q_sub->the_post();
							get_template_part( 'content', 'link' );
						}
						?>
					</div>
					<?php
				}
			}
			?>
			
			<p class="shop-disclaimer">Affiliate links may be used.</p>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>