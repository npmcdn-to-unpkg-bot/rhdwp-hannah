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

	session_start();

	if ( is_home() || is_single() || is_archive() || is_search() ) {
		$body_classes[] = 'blog-area';

		$_SESSION['blog_area'] = true;
	} else {
		$_SESSION['blog_area'] = false;
	}

	session_write_close();

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

	return rhd_ghost_button( 'Read More', get_permalink( $post ), null, '', true, false );
}
add_filter( 'excerpt_more', 'rhd_custom_excerpt_read_more' );


/**
 * rhd_entry_header function.
 *
 * @access public
 * @param string $sep (default: ' &mdash; ')
 * @return void
 */
function rhd_entry_header( $sep = ' &mdash; ' ) {
	echo '<p class="entry-details">' . get_the_time( get_option( 'date_format' ) ) . $sep;
	comments_popup_link( 'Leave a Comment', '1 comment', '% Comments', null, '' );
	echo '</p>';
}


/**
 * rhd_front_page_query_offset function.
 * 
 * @access public
 * @param mixed &$query
 * @return void
 */
function rhd_front_page_query_offset( &$query ) {
	if ( ! $query->is_home() || ! $query->is_main_query() )
		return;
	
	$offset = 1;
	$ppp = get_option( 'posts_per_page' );

	if ( $query->is_paged ) {
		$page_offset = $offset + ( ( $query->query_vars['paged'] - 1 ) * $ppp );
		
        $query->set('offset', $page_offset );
	} else {
		$query->set( 'offset', $offset );
	}
}
add_action( 'pre_get_posts', 'rhd_front_page_query_offset', 1 );


/**
 * rhd_adjust_offset_pagination function.
 * 
 * @access public
 * @param mixed $found_posts
 * @param mixed $query
 * @return void
 */
function rhd_adjust_offset_pagination($found_posts, $query) {
    $offset = 1;

    if ( $query->is_home() && $query->is_main_query() ) {
        return $found_posts - $offset;
    }
    return $found_posts;
}
add_filter( 'found_posts', 'rhd_adjust_offset_pagination', 1, 2 );


/**
 * rhd_archive_grid function.
 * 
 * @access public
 * @param mixed $parent_slug
 * @return void
 */
function rhd_archive_grid( $parent_slug ) {
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
		
		$args['category_name'] = $cat_slug;
		$cat = get_category_by_slug( $cat_slug );
		$cat_id = $cat->term_id;
		$cat_name = $cat->name;
		$cat_url = get_category_link( $cat_id );
		
		$query = new WP_Query( $args );
		?>
		<div class="<?php echo $parent_slug; ?>-grid-container archive-grid-container">
			<h2 class="cat-title"><a href="<?php echo $cat_url; ?>" rel="bookmark"><?php echo $cat_name; ?></a></h2>
			<?php if ( $query->have_posts() ) : ?>
				<div id="<?php echo $cat_slug; ?>-grid" class="archive-grid">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'grid' ); ?>
					<?php endwhile; ?>
				</div>
				<div class="archive-more">
					<?php rhd_ghost_button( 'See More &rarr;', $cat_url, '', 'center', false, true ); ?>
				</div>
			<?php endif; ?>
			<?php unset( $q ); ?>
		</div>
		<?php
	}
}