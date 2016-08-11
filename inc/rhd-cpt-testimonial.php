<?php
/**
 * RHD Custom Post Types
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


function testimonial_init() {
	register_post_type( 'testimonial', array(
		'labels'            => array(
			'name'                => __( 'Testimonials', 'rhd' ),
			'singular_name'       => __( 'Testimonial', 'rhd' ),
			'all_items'           => __( 'All Testimonials', 'rhd' ),
			'new_item'            => __( 'New Testimonial', 'rhd' ),
			'add_new'             => __( 'Add New', 'rhd' ),
			'add_new_item'        => __( 'Add New Testimonial', 'rhd' ),
			'edit_item'           => __( 'Edit Testimonial', 'rhd' ),
			'view_item'           => __( 'View Testimonial', 'rhd' ),
			'search_items'        => __( 'Search Testimonials', 'rhd' ),
			'not_found'           => __( 'No Testimonials found', 'rhd' ),
			'not_found_in_trash'  => __( 'No Testimonials found in trash', 'rhd' ),
			'parent_item_colon'   => __( 'Parent Testimonial', 'rhd' ),
			'menu_name'           => __( 'Testimonials', 'rhd' ),
		),
		'public'            => false,
		'exclude_from_search'	=> true,
		'publicly_queryable'	=> false,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => false,
		'menu_position'		=> 15,
		'supports'          => array( 'title', 'thumbnail' ),
		'has_archive'       => false,
		'rewrite'           => false,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-format-quote',
		'show_in_rest'      => false,
		'register_meta_box_cb'	=> 'rhd_add_testimonial_meta_boxes'
	) );

}
add_action( 'init', 'testimonial_init' );

function testimonial_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['testimonial'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Testimonial updated. <a target="_blank" href="%s">View Testimonial</a>', 'rhd'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'rhd'),
		3 => __('Custom field deleted.', 'rhd'),
		4 => __('Testimonial updated.', 'rhd'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Testimonial restored to revision from %s', 'rhd'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Testimonial published. <a href="%s">View Testimonial</a>', 'rhd'), esc_url( $permalink ) ),
		7 => __('Testimonial saved.', 'rhd'),
		8 => sprintf( __('Testimonial submitted. <a target="_blank" href="%s">Preview Testimonial</a>', 'rhd'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Testimonial</a>', 'rhd'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Testimonial draft updated. <a target="_blank" href="%s">Preview Testimonial</a>', 'rhd'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'testimonial_updated_messages' );


// SAMPLE META BOX

/**
 * rhd_add_testimonial_meta_boxes function.
 *
 * @access public
 * @return void
 */
function rhd_add_testimonial_meta_boxes() {
	add_meta_box(
		'rhd_testimonial_meta',
		__( 'Quotations and Testimonials which can be placed anywhere using shortcodes.', 'rhd' ),
		'rhd_testimonial_meta_callback',
		'testimonial',
		'normal',
		'high'
	);

	add_meta_box(
		'rhd_testimonial_shortcode',
		__( 'Testimonial Shortcode' ),
		'rhd_testimonial_meta_sc_callback',
		'testimonial',
		'side',
		'high'
	);
}

/**
 * rhd_testimonial_meta_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_testimonial_meta_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'rhd_testimonial_meta_meta_box', 'rhd_testimonial_meta_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<p>
	    <label for="rhd-testimonial-text"><?php _e( 'Quotation/Content', 'rhd' )?>
		    <textarea id="rhd-testimonial-text" name="rhd-testimonial-text" class="widefat" rows="3"><?php if ( isset( $meta['rhd_testimonial_text'] ) ) echo $meta['rhd_testimonial_text'][0]; ?></textarea>
	    </label>
	</p>

	<p>
		<label for="rhd-testimonial-attr"><?php _e( 'Attribution/Speaker/Author' ); ?>
			<span style="font-style: italic;">Using multiple lines is allowed.</span>
			<textarea type="text" id="rhd-testimomnial-attr" name="rhd-testimonial-attr" class="widefat" rows="3"><?php if ( isset( $meta['rhd_testimonial_attr'] ) ) echo $meta['rhd_testimonial_attr'][0]; ?></textarea>
		</label>
	</p>
<?php
}


function rhd_testimonial_meta_sc_callback( $post ) {
	?>
	<p>This shortcode can be used in any Post or Page content area.</p>
	<p style="text-align: center; font-weight: bold;">[testimonial name="<?php echo $post->post_name; ?>"]</p>
	<?php
}


function rhd_save_testimonial_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['rhd_testimonial_meta_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['rhd_testimonial_meta_meta_box_nonce'], 'rhd_testimonial_meta_meta_box' ) ) {
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
	if( isset( $_POST[ 'rhd-testimonial-text' ] ) ) {
		update_post_meta( $post_id, 'rhd_testimonial_text', esc_textarea( $_POST[ 'rhd-testimonial-text' ] ) );
	}

	if( isset( $_POST[ 'rhd-testimonial-attr' ] ) ) {
		$sanitized = implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $_POST['rhd-testimonial-attr'] ) ) );
		update_post_meta( $post_id, 'rhd_testimonial_attr', $sanitized );
	}
}
add_action( 'save_post', 'rhd_save_testimonial_meta_box_data' );


function rhd_testimonial_display_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'name' => null
	), $atts );

	extract( $a );

	$args = array(
		'post_type' => 'testimonial',
		'name' => $name,
		'posts_per_page' => 1
	);
	$q = get_posts( $args );

	if ( ! $q ) {
		return;
	} else {
		$test = $q[0];
		setup_postdata( $GLOBALS['post'] =& $test );

		$id = get_the_ID();

		$meta = get_post_meta( $id );
		$quote = isset( $meta['rhd_testimonial_text'] ) ? esc_textarea( $meta['rhd_testimonial_text'][0] ) : '';
		$attrib = isset( $meta['rhd_testimonial_attr'] ) ? array_map( 'esc_attr', explode( "\n", $meta['rhd_testimonial_attr'][0] ) ) : '';

		// Trim quotation marks, if present
		$quote = preg_replace( '/^&amp;(quot;|apos;|lsquo;|ldquo;)(.*?)&amp;(quot;|apos;|lsquo;|ldquo;)$/', "$2", $quote );

		$out = "<div class=\"rhd-testimonial-{$id} rhd-testimonial\">"
				. get_the_post_thumbnail( $id, 'medium', array( 'class' => 'testimonial-thumb' ) )
				.	"<div class=\"testimonial-content\">
						<blockquote class=\"quote\">&ldquo;{$quote}&rdquo;</blockquote>
						<div class=\"attribution\">"
				. 			"&mdash; " . implode( "<br />", $attrib )
				.		"</div>
					</div>
				</div>";

		wp_reset_postdata();
	}

	return $out;
}
add_shortcode( 'testimonial', 'rhd_testimonial_display_shortcode' );