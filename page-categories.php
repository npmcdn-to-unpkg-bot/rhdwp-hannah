<?php
/**
 * The "Categories" template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content page-categories">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile ?>

			<?php endif; ?>

			<?php $cats = get_categories( array( 'orderby' => 'name' ) ); ?>

			<div class="post-grid cat-child cat-<?php echo $cat->term_id; ?>">
				<?php foreach ( $cats as $cat ) : ?>
					<?php
						$updir = wp_upload_dir();
						if ( function_exists( 'z_taxonomy_image_url' ) ) {
							$url = z_taxonomy_image_url( $cat->term_id, 'archive' );

							if ( ! $url )
								$url = $updir['baseurl'] . '/2015/10/fallback.jpg';
						}

						$cat_link = get_category_link ( $cat->term_id );
					?>

					<div id="category-<?php echo $cat->slug; ?>" class="category-grid-item post">
						<div class="entry-thumbnail">
							<a href="<?php echo $cat_link; ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), $cat->name ) ); ?>" rel="bookmark">
								<img src="<?php echo $url; ?>" alt="<?php echo $cat->name; ?>">
								<h2 class="entry-title"><?php echo $cat->name; ?></h2>
							</a>
						</div><!-- .entry-header -->
					</div><!-- #post -->

				<?php endforeach; ?>
			</div>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>