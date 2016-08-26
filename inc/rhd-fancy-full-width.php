<?php
/**
 * rhd_add_page_meta_boxes function.
 *
 * @access public
 * @return void
 */
function rhd_add_page_meta_boxes() {
	add_meta_box(
		'rhd_page_overlay_cta_meta',
		__( 'Header Overlay', 'rhd' ),
		'rhd_page_overlay_cta_meta_callback',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'rhd_add_page_meta_boxes' );


/**
 * rhd_page_overlay_cta_meta_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_page_overlay_cta_meta_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'rhd_page_overlay_cta_meta_meta_box', 'rhd_page_overlay_cta_meta_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<p>
		Choosing an image will cause any text entered to <em>not</em> be displayed.<br />
		<em>This functionality is automatically enabled when the "Fancy Full Width" template is seleted and a <a href="#postimagediv">Featured Image</a> is set.</em>
	</p>

	<div class="rhd-row-content">
		<p>
			<strong><?php _e( 'Header Overlay Style', 'rhd' ); ?></strong><br />
			<label for="rhd-page-overlay-style-cta">
				<input type="radio" name="rhd-page-overlay-style" id="rhd-page-overlay-style-cta" value="cta" <?php if ( isset( $meta['rhd_page_overlay_style'] ) ) checked( $meta['rhd_page_overlay_style'][0], 'cta' ); ?>>
				<?php _e( 'Text + Button', 'rhd' )?>
			</label>&nbsp;
			<label for="rhd-page-overlay-style-image">
				<input type="radio" name="rhd-page-overlay-style" id="rhd-page-overlay-style-image" value="image" <?php if ( isset( $meta['rhd_page_overlay_style'] ) ) checked( $meta['rhd_page_overlay_style'][0], 'image' ); ?>>
				<?php _e( 'Image', 'rhd' )?>
			</label>&nbsp;
			<label for="rhd-page-overlay-style-off">
				<input type="radio" name="rhd-page-overlay-style" id="rhd-page-overlay-style-off" value="off" <?php if ( ( isset( $meta['rhd_page_overlay_style'] ) && $meta['rhd_page_overlay_style'][0] == 'off' ) || ! isset( $meta['rhd_page_overlay_style'] ) ) echo 'checked="checked"'; ?>>
				<?php _e( 'Off', 'rhd' )?>
			</label>
		</p>
	</div>

	<div id="rhd-page-overlay-cta-options" class="rhd-page-overlay-options" style="display: none;">
		<p>
			<label for="rhd-page-overlay-headline" class="rhd-page-overlay-headline"><?php _e( 'Headline', 'rhd' )?></label><br />
			<input type="text" name="rhd-page-overlay-headline" id="rhd-page-overlay-headline" class="widefat" value="<?php if ( isset( $meta['rhd_page_overlay_headline'] ) ) echo $meta['rhd_page_overlay_headline'][0]; ?>" />
		</p>
		<p>
			<label for="rhd-page-overlay-text" class="rhd-page-overlay-text"><?php _e( 'Page Header Text (No HTML allowed)', 'rhd' )?></label><br />
			<textarea name="rhd-page-overlay-text" id="rhd-page-overlay-text" class="widefat"><?php if ( isset( $meta['rhd_page_overlay_text'] ) ) echo $meta['rhd_page_overlay_text'][0]; ?></textarea>
		</p>
		<p>
			<label for="rhd-page-overlay-button-value" class="rhd-page-overlay-button-value"><?php _e( 'Button Text', 'rhd' )?></label><br />
			<input type="text" name="rhd-page-overlay-button-value" id="rhd-page-overlay-button-value" class="widefat" value="<?php if ( isset( $meta['rhd_page_overlay_button_value'] ) ) echo $meta['rhd_page_overlay_button_value'][0]; ?>" />
		</p>
		<p>
			<label for="rhd-page-overlay-button-link" class="rhd-page-overlay-button-link"><?php _e( 'Button Link', 'rhd' )?></label><br />
			<input type="text" name="rhd-page-overlay-button-link" id="rhd-page-overlay-button-link" class="widefat" value="<?php if ( isset( $meta['rhd_page_overlay_button_link'] ) ) echo $meta['rhd_page_overlay_button_link'][0]; ?>" />
		</p>
	</div>

	<div id="rhd-page-overlay-image-options" class="rhd-page-overlay-options" style="display: none;">
		<p>
			<?php
			$att = get_post( $meta['rhd_page_overlay_image'][0] );
			$image = wp_get_attachment_image_src( absint( $att->ID ), 'medium' );
			?>

			<input type="hidden" name="rhd-page-overlay-image-id" id="rhd-page-overlay-image-id" value="<?php if ( isset( $meta['rhd_page_overlay_image'] ) ) echo $meta['rhd_page_overlay_image'][0]; ?>" />
			<input type="button" id="rhd-page-overlay-image-button" class="button" value="<?php _e( 'Select/Upload Image', 'rhd' )?>" />
			<figure id="rhd-page-overlay-image">
				<img src="<?php echo isset( $image[0] ) ? $image[0] : ''; ?>" style="width: auto; max-height: 150px;" title="<?php echo isset( $image[0] ) ? $att->post_title : ''; ?>" />
				<figcaption><?php echo isset( $image[0] ) ? $att->post_title : ''; ?></figcaption>
			</figure>

			<a href="#" id="rhd-page-overlay-clear-image" style="font-size: 0.8em;">Clear Image</a>
		</p>
	</div>

	<div id="rhd-page-overlay-bg-option">
		<hr noshade="noshade">
		<p>
			<input type="checkbox" name="rhd-page-overlay-bg" id="rhd-page-overlay-bg" value="yes" <?php if ( isset( $meta['rhd_page_overlay_bg'] ) ) checked( $meta['rhd_page_overlay_bg'][0], 'yes' ); ?>  />
			<label for="rhd-page-overlay-bg" class="rhd-page-overlay-bg"><?php _e( 'Add semi-transparent background', 'rhd' )?></label>
		</p>
	</div>
<?php
}

function rhd_save_page_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['rhd_page_overlay_cta_meta_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['rhd_page_overlay_cta_meta_meta_box_nonce'], 'rhd_page_overlay_cta_meta_meta_box' ) ) {
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
	if ( isset( $_POST['rhd-page-overlay-style'] ) ) {
		update_post_meta( $post_id, 'rhd_page_overlay_style', $_POST['rhd-page-overlay-style'] );
	}

	if( isset( $_POST['rhd-page-overlay-headline'] ) ) {
		update_post_meta( $post_id, 'rhd_page_overlay_headline', sanitize_text_field( $_POST['rhd-page-overlay-headline'] ) );
	}

	if( isset( $_POST['rhd-page-overlay-text'] ) ) {
		$sanitized = implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $_POST['rhd-page-overlay-text'] ) ) );
		update_post_meta( $post_id, 'rhd_page_overlay_text', $sanitized );
	}

	if( isset( $_POST['rhd-page-overlay-button-value'] ) ) {
		update_post_meta( $post_id, 'rhd_page_overlay_button_value', sanitize_text_field( $_POST['rhd-page-overlay-button-value'] ) );
	}

	if( isset( $_POST['rhd-page-overlay-button-link'] ) ) {
		update_post_meta( $post_id, 'rhd_page_overlay_button_link', esc_url_raw( $_POST['rhd-page-overlay-button-link'] ) );
	}

	if ( isset( $_POST['rhd-page-overlay-bg'] ) ) {
		update_post_meta( $post_id, 'rhd_page_overlay_bg', 'yes' );
	} else {
		update_post_meta( $post_id, 'rhd_page_overlay_bg', '' );
	}

	if ( isset( $_POST['rhd-page-overlay-image-id'] ) ) {
		update_post_meta( $post_id, 'rhd_page_overlay_image', absint( $_POST['rhd-page-overlay-image-id'] ) );
	} else {
		update_post_meta( $post_id, 'rhd_page_overlay_image', '' );
	}
}
add_action( 'save_post', 'rhd_save_page_meta_box_data' );


/**
 * rhd_page_overlay_media_enqueue function.
 *
 * @access public
 * @return void
 */
function rhd_page_overlay_media_enqueue() {
    global $typenow;
    if( $typenow == 'page' ) {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script( 'rhd-page-overlay-media', RHD_THEME_DIR . '/js/page-overlay-media.js', array( 'jquery' ) );
        wp_localize_script( 'rhd-page-overlay-media', 'rhd_page_overlay',
            array(
                'title' => __( 'Choose or Upload Image', 'rhd' ),
                'button' => __( 'Select Image', 'rhd' ),
            )
        );
        wp_enqueue_script( 'rhd-page-overlay-media' );
    }
}
add_action( 'admin_enqueue_scripts', 'rhd_page_overlay_media_enqueue' );


/**
 * rhd_full_width_cta_overlay function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_full_width_cta_overlay( $post_id ) {
	$meta = get_post_meta( $post_id );

	$style = $meta['rhd_page_overlay_style'][0];

	$classes = array( "rhd-page-style-{$style}" );

	$classes[] = ( $meta['rhd_page_overlay_bg'][0] == 'yes' ) ? 'bg' : '';
	$class = implode( " ", $classes );

	$enabled = ( $style && ( $style != 'off' && $style !== false ) ) ? true : false;

	if ( $enabled ) {
		$out =	"
				<div class=\"rhd-page-overlay-cta-container\">
					<div class=\"rhd-page-overlay-cta\">
						<div class=\"rhd-page-overlay-cta-inner {$class}\">
				";
	}

	switch( $style ) {
		case 'cta':
			$has_content = ( $meta['rhd_page_overlay_headline'] || $meta['rhd_page_overlay_text'] ) ? true : false;
			$has_button = ( $meta['rhd_page_overlay_button_value'] && $meta['rhd_page_overlay_button_link'] ) ? true : false;

			if ( $has_content ) {
				if ( $meta['rhd_page_overlay_headline'] ) {
					$out .= '<h3 class="page-overlay-headline">' . esc_attr( $meta['rhd_page_overlay_headline'][0] ) . '</h3>';
				}

				if ( $meta['rhd_page_overlay_text'] ) {
					$out .= '<p class="page-overlay-text">' . nl2br( $meta['rhd_page_overlay_text'][0] ) . '</p>';
				}
			}

			if ( $has_button ) {
				$out .= rhd_ghost_button( esc_attr( $meta['rhd_page_overlay_button_value'][0] ), esc_url( $meta['rhd_page_overlay_button_link'][0] ), '', 'center', true, false );
			}
			break;

		case 'image':
			$out .= wp_get_attachment_image( $meta['rhd_page_overlay_image'][0], 'large', false, array( 'class' => 'rhd-page-overlay-image' ) );
			break;

		case 'off':
			break;
	}

	if ( $enabled ) {
		$out .= '
						</div>
					</div>
				</div>
				';
	}

	return $out;
}


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

	echo $out;
}


/* ==========================================================================
	"Big Image" Shortcode
   ========================================================================== */

/**
 * rhd_big_image_image_shortcode function.
 *
 * @access public
 * @param mixed $atts
 * @param string $content (default: "")
 * @return void
 */
function rhd_big_image_image_shortcode( $atts, $content ) {
	preg_match( '/<img class=".*?wp-image-([0-9]*)/', $content, $matches );

	if ( $matches[0] ) {
		$att_id = $matches[1];
		$img = wp_get_attachment_image( $att_id, 'full' );

		$output = '
			<div class="rhd-big-image-container" data-scrollax-parent="true">
				<div class="rhd-big-image" data-scrollax="properties: { \'translateY\': \'30%\' }">' . $img . '</div>
			</div>
		';
	} else {
		$output = false;
	}

	return $output;
}
add_shortcode( 'big-image', 'rhd_big_image_image_shortcode' );