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
		'posts_per_page'	=> 6,
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
						<?php get_template_part( 'template-parts/content', 'grid-square' ); ?>
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


/**
 * rhd_post_grid function.
 *
 * @access public
 * @param WP_Query $q (default: null)
 * @param string $class (default: null)
 * @param string $size (default: 'full')
 * @return void
 *
 * If used outside the Loop, must be passed a WP_Query object.
 */
function rhd_post_grid( WP_Query $q = null, $class = null, $size = 'full' ) {
	global $wp_query;

	$q = ( $q === null ) ? $q = $wp_query : $q;
	$size = 'grid-' . $size;
	?>
	<div class="post-grid post-grid-full <?php echo $class; ?>">
		<div class="post-grid-sizer"></div>
		<div class="post-gutter-sizer"></div>
		<?php while ( $q->have_posts() ) : $q->the_post(); ?>
			<?php get_template_part( 'template-parts/content', $size ); ?>
		<?php endwhile; ?>
	</div>
	<?php
}


/**
 * rhd_featured_meta function.
 *
 * @access public
 * @return void
 */
function rhd_featured_meta() {
	add_meta_box( 'rhd_featured_meta', __( 'Home Page Feature' ), 'rhd_featured_meta_callback', array( 'post', 'page' ), 'side', 'default' );
}
add_action( 'add_meta_boxes', 'rhd_featured_meta' );


/**
 * rhd_featured_meta_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_featured_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'rhd_featured_meta_nonce' );
	$featured = get_option( 'rhd_featured_post' );
	$post_is_featured = ( $featured === $post->ID ) ? 'yes' : 'no';
	echo $featured;
	?>

	<p>
		<span class="rhd-row-title"><?php _e( 'Feature this ' . $post->post_type . ' on the home page.', 'rhd' )?></span>
		<div class="rhd-row-content">
			<label for="featured-post-checkbox">
				<input type="checkbox" name="featured-post-checkbox" id="featured-post-checkbox" value="yes" <?php checked( $post_is_featured , 'yes' ); ?> />
				<input type="hidden" name="featured-post-id" value="<?php echo $post->ID; ?>">
				<?php _e( 'Featured', 'rhd' )?>
			</label>
		</div>
	</p>
	<?php
}


/**
 * rhd_featured_meta_save function.
 *
 * @access public
 * @param mixed $post_id
 * @return void
 */
function rhd_featured_meta_save( $post_id ) {
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'rhd_nonce' ] ) && wp_verify_nonce( $_POST[ 'rhd_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and saves
	if( isset( $_POST['featured-post-checkbox'] ) ) {
		update_option( 'rhd_featured_post', $_POST['featured-post-id'] );
	} else {
		// Unset the featured post ID completely if this is currently set (user unchecks the box manually)
		$current = get_option( 'rhd_featured_post' );

		if ( $current == $_POST['featured-post-id'] ) {
			update_option( 'rhd_featured_post', '' );
		}
	}

}
add_action( 'save_post', 'rhd_featured_meta_save' );


/**
 * rhd_get_featured_post function.
 *
 * @access public
 * @return void
 */
function rhd_featured_post() {
	$featured_id = get_option( 'rhd_featured_post' );
	$featured = get_post( $featured_id );

	if ( $featured ) {
		$thumb_id = get_post_thumbnail_id( $featured_id );
		$img = wp_get_attachment_image( $thumb_id, 'medium' );
		$link = get_permalink( $featured_id );
	} else {
		return false;
	}

	echo "
		<a href='{$link}' rel='bookmark'>
			$img
		</a>
		";
}


function rhd_room_reveal_related_posts() {
	global $post;

	$tag_list = wp_get_post_terms( $post->ID, 'reveal_tag' );
	$tags = array();
	foreach( $tag_list as $tag ) {
		$tags[] = $tag->term_id;
	}

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => 6,
		'tax_query' => array(
			array(
				'taxonomy' => 'reveal_tag',
				'field' => 'term_id',
				'terms' => $tags
			)
		)
	);
	$tag_q = new WP_Query( $args );

	echo '<div class="page-header reveal-posts-header"><h2 class="page-title reveal-title">Inside This Reveal...</h2></div>';

	rhd_post_grid( $tag_q, 'room-reveal-related-posts' );
}