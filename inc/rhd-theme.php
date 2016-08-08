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
 * rhd_site_branding function.
 *
 * @access public
 * @param string $sel (default: 'logo')
 * @param mixed $alt_size (default: null)
 * @param string $class (default: null)
 * @return void
 */
function rhd_site_branding( $sel = 'logo', $alt_size = null, $class = null ) {
	$images = array(
		'logo' => 7,
		'full' => 8,
		'icon' => 5
	);

	$size = $alt_size ? $alt_size : 'medium';

	return wp_get_attachment_image( $images[$sel], $size, "", array( 'class' => $class ) );
}


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


/**
 * rhd_add_page_meta_boxes function.
 *
 * @access public
 * @return void
 */
function rhd_add_page_meta_boxes() {
	add_meta_box(
		'rhd_page_meta',
		__( 'Page Header CTA', 'rhd' ),
		'rhd_page_meta_callback',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'rhd_add_page_meta_boxes' );

/**
 * rhd_page_meta_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_page_meta_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'rhd_page_meta_meta_box', 'rhd_page_meta_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<p>
		You may enter an optional bit of content and Call To Action here to be superimposed over this page's main featured image.<br />
		<em>This functionality is automatically disabled if no <a href="#postimagediv">Featured Image</a> is specified.</em>
	</p>

	<hr noshade=noshade />

	<p>
		<label for="rhd-page-header-headline" class="rhd-page-header-headline"><?php _e( 'Headline', 'rhd' )?></label><br />
		<input type="text" name="rhd-page-header-headline" id="rhd-page-header-headline" class="widefat" value="<?php if ( isset ( $meta['rhd_page_header_headline'] ) ) echo $meta['rhd_page_header_headline'][0]; ?>" />
	</p>
	<p>
		<label for="rhd-page-header-text" class="rhd-page-header-text"><?php _e( 'Page Header Text (No HTML allowed)', 'rhd' )?></label><br />
		<textarea name="rhd-page-header-text" id="rhd-page-header-text" class="widefat"><?php if ( isset ( $meta['rhd_page_header_text'] ) ) echo $meta['rhd_page_header_text'][0]; ?></textarea>
	</p>
	<p>
		<label for="rhd-page-header-button-value" class="rhd-page-header-button-value"><?php _e( 'Button Text', 'rhd' )?></label><br />
		<input type="text" name="rhd-page-header-button-value" id="rhd-page-header-button-value" class="widefat" value="<?php if ( isset ( $meta['rhd_page_header_button_value'] ) ) echo $meta['rhd_page_header_button_value'][0]; ?>" />
	</p>
	<p>
		<label for="rhd-page-header-button-link" class="rhd-page-header-button-link"><?php _e( 'Button Link', 'rhd' )?></label><br />
		<input type="text" name="rhd-page-header-button-link" id="rhd-page-header-button-link" class="widefat" value="<?php if ( isset ( $meta['rhd_page_header_button_link'] ) ) echo $meta['rhd_page_header_button_link'][0]; ?>" />
	</p>
	<p>
		<input type="checkbox" name="rhd-page-header-bg" id="rhd-page-header-bg" value="yes" <?php if ( isset ( $meta['rhd_page_header_bg'] ) ) checked( $meta['rhd_page_header_bg'][0], 'yes' ); ?>  />
		<label for="rhd-page-header-bg" class="rhd-page-header-bg"><?php _e( 'Add semi-transparent background', 'rhd' )?></label>
	</p>
<?php
}

function rhd_save_page_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['rhd_page_meta_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['rhd_page_meta_meta_box_nonce'], 'rhd_page_meta_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Checks for input and saves if needed
	if( isset( $_POST['rhd-page-header-headline'] ) ) {
		update_post_meta( $post_id, 'rhd_page_header_headline', sanitize_text_field( $_POST['rhd-page-header-headline'] ) );
	}

	if( isset( $_POST['rhd-page-header-text'] ) ) {
		$sanitized = implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $_POST['rhd-page-header-text'] ) ) );
		update_post_meta( $post_id, 'rhd_page_header_text', $sanitized );
	}

	if( isset( $_POST['rhd-page-header-button-value'] ) ) {
		update_post_meta( $post_id, 'rhd_page_header_button_value', sanitize_text_field( $_POST['rhd-page-header-button-value'] ) );
	}

	if( isset( $_POST['rhd-page-header-button-link'] ) ) {
		update_post_meta( $post_id, 'rhd_page_header_button_link', esc_url_raw( $_POST['rhd-page-header-button-link'] ) );
	}

	if ( isset( $_POST['rhd-page-header-bg'] ) ) {
		update_post_meta( $post_id, 'rhd_page_header_bg', 'yes' );
	} else {
		update_post_meta( $post_id, 'rhd_page_header_bg', '' );
	}
}
add_action( 'save_post', 'rhd_save_page_meta_box_data' );


/**
 * rhd_full_width_thumbnail function.
 *
 * @access public
 * @param int $thumb_id
 * @return void
 */
function rhd_full_width_thumbnail( $thumb_id ) {
	global $post;

	$thumb_id = $thumb_id ? $thumb_id : 8;
	$default = $thumb_id == 8 ? true : false;

	if ( ! $default ) {
		$class = 'fixed-bg';
	} else {
		$class = 'default-thumb';
	}

	$img = wp_get_attachment_image( $thumb_id, 'full' );

	$out =	"<div class=\"rhd-full-width-thumbnail-container {$class}\">";

	$out .= "
				<div class=\"rhd-full-width-thumbnail\">
					{$img}
				</div>
			</div>
			";

	if ( $default )
		$out .= '<h2 class="page-title mobile-only">' . $post->post_title . '</h2>';

	echo $out;
}


/**
 * rhd_full_width_format_featured_cta function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_full_width_format_featured_cta( $post_id ) {
	$meta = get_post_meta( $post_id );

	$has_content = ( $meta['rhd_page_header_headline'] || $meta['rhd_page_header_text'] ) ? true : false;
	$has_button = ( $meta['rhd_page_header_button_value'] && $meta['rhd_page_header_button_link'] ) ? true : false;

	$with_bg = ( $meta['rhd_page_header_bg'][0] == 'yes' ) ? 'bg' : '';

	if ( $has_content || $has_button ) {
		$out =	"
				<div class=\"rhd-page-header-cta-container\">
					<div class=\"rhd-page-header-cta\">
						<div class=\"rhd-page-header-cta-inner {$with_bg}\">
				";

		if ( $has_content ) {
			if ( $meta['rhd_page_header_headline'] ) {
				$out .= '<h3 class="page-header-headline">' . esc_attr( $meta['rhd_page_header_headline'][0] ) . '</h3>';
			}

			if ( $meta['rhd_page_header_text'] ) {
				$out .= '<p class="page-header-text">' . nl2br( $meta['rhd_page_header_text'][0] ) . '</p>';
			}
		}

		if ( $has_button ) {
			$out .= rhd_ghost_button( esc_attr( $meta['rhd_page_header_button_value'][0] ), esc_url( $meta['rhd_page_header_button_link'][0] ), '', 'center', true, false );
		}

		$out .= '
							</div>
						</div>
					</div>
				';
	}

	return $out;
}