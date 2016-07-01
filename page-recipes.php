<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content full-width">
	
	<?php rhd_metabar( '', array( 'cats' => true, 'archives' => true, 'search' => false ) ); ?>
	
	<div id="content" role="main">
		<?php
		$args = array(
			'post_type'			=> 'post',
			'posts_per_page'	=> 8,
		);
		?>
		
		<?php
		$cats = array( 'appetizers', 'breakfast', 'dinner', 'salads', 'desserts' );
		$q = array(); // Array of queries
		$i = 0;
		foreach ( $cats as $cat_slug ) {
			$args['category_name'] = $cat_slug;
			$cat = get_category_by_slug( $cat_slug );
			$cat_id = $cat->cat_ID;
			$cat_name = $cat->cat_name;
			$cat_url = get_category_link( $cat_id );
			
			$query = new WP_Query( $args );
			?>
			<div class="recipe-category">
				<h2 class="cat-title"><a href="<?php echo $cat_url; ?>" rel="bookmark"><?php echo $cat_name; ?></a></h2>
				<?php if ( $query->have_posts() ) : ?>
					<div class="cat-grid">
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<?php get_template_part( 'template-parts/content', 'grid' ); ?>
						<?php endwhile; ?>
					</div>
					<?php rhd_ghost_button( 'See More &rarr;', $cat_url, '', 'center', false, true ); ?>
				<?php endif; ?>
				<?php unset( $q ); ?>
			</div>
			<?php
		} ?>
	</div>
</section>

<?php get_footer(); ?>