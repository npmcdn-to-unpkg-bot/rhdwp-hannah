<?php
/**
 * RHD Theme Customizations
 *
 * ROUNDHOUSE DESIGNS
 *
 * Add all theme customization functions here.
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


 /**
 * rhd_body_class function.
 *
 * @access public
 * @return void
 */
function rhd_body_class( $body_classes ) {
	// Basic front page & device detection
	$body_classes[] = ( is_front_page() ) ? 'front-page' : '';
	$body_classes[] = ( rhd_is_mobile() ) ?  'mobile' : '';
	$body_classes[] = ( wp_is_mobile() && ! rhd_is_mobile() ) ? 'tablet' : '';
	$body_classes[] = ( ! wp_is_mobile() && ! rhd_is_mobile() ) ? 'desktop' : '';

	if ( is_home() || is_single() || is_archive() || is_search() ) {
		$body_classes[] = 'blog-area';
	}

	return $body_classes;
}
add_filter( 'body_class', 'rhd_body_class' );


/**
 * rhd_custom_excerpt_length function.
 *
 * @access public
 * @param mixed $length
 * @return void
 */
function rhd_custom_excerpt_length( $length) {
	return 40;
}
add_filter( 'excerpt_length', 'rhd_custom_excerpt_length' );


/**
 * rhd_custom_excerpt_read_more function.
 *
 * @access public
 * @param mixed $more
 * @return void
 */
function rhd_custom_excerpt_read_more( $more ) {
	global $post;

	return rhd_ghost_button( 'Read More', get_permalink( $post ), null, 'center', true, false );
}
add_filter( 'excerpt_more', 'rhd_custom_excerpt_read_more' );


/**
 * rhd_subcat_grid function.
 *
 * @access public
 * @param mixed $parent_slug
 * @param bool $uncat (default: false)
 * @return void
 */
function rhd_subcat_grid( $parent_slug, $uncat = false ) {
	$args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> 8,
	);

	$parent = get_category_by_slug( $parent_slug );
	$parent_id = $parent->term_id;
	$cats = get_terms( 'category', "child_of=$parent_id" );

	$q = array(); // Array of queries
	$i = 0;
	foreach ( $cats as $cat ) {
		$cat_slug = $cat->slug;

		// Exclude uncategorized (enabled by default)
		if ( $uncat === false && $cat_slug == 'uncategorized' )
			continue;

		$args['category_name'] = $cat_slug;
		$cat = get_category_by_slug( $cat_slug );
		$cat_id = $cat->term_id;
		$cat_name = $cat->name;
		$cat_url = get_category_link( $cat_id );

		$query = new WP_Query( $args );
		?>
		<div class="<?php echo $parent_slug; ?>-grid-container <?php echo $cat-slug; ?>-subcat-container subcat-grid-container">
			<h2 class="subcat-title"><a href="<?php echo $cat_url; ?>" rel="bookmark"><?php echo $cat_name; ?></a></h2>
			<?php if ( $query->have_posts() ) : ?>
				<div id="<?php echo $cat_slug; ?>-grid" class="post-grid">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'grid' ); ?>
					<?php endwhile; ?>
				</div>
				<div class="subcat-more">
					<?php rhd_ghost_button( 'See More &rarr;', $cat_url, '', 'center', false, true ); ?>
				</div>
			<?php endif; ?>
			<?php unset( $q ); ?>
		</div>
		<?php
	}
}