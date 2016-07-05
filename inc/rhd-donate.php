<?php
/**
 * RHD Theme - Donation Functions and Meta Boxes
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhd
 **/


/* ==========================================================================
	Donation Pages CPT
   ========================================================================== */


function rhd_cpt_init()
{
	$labels = array(
		'name' => 'Donation Pages',
		'singular_name' => 'Donation Page',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Donation Page',
		'edit_item' => 'Edit Donation Page',
		'new_item' => 'New Donation page',
		'view_item' => 'View Donation Page',
		'search_items' => 'Search Donation Pages',
	);

	$args = array(
		'labels' => $labels,
		'description' => __( 'Individual pages for collecting donations.', 'rhd' ),
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'description' => '',
		'menu_position' => 5,
		'menu_icon' => 'dashicons-star-empty',
		'public' => true,
		'hierarchical' => true,
		'has_archive' => false,
		'rewrite' =>
			array (
				'slug' => 'give',
				'with_front' => false,
				'feeds' => false,
				'pages' => true,
				'ep_mask' => 0,
			),
		'query_var' => true,
		'can_export' => true,
		'supports' =>
			array( 'title' , 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
	);

	register_post_type( 'donation_page', $args );
}
add_action( 'init', 'rhd_cpt_init' );


/**
 * rhd_add_donation_meta_boxes function.
 *
 * @access public
 * @return void
 */
function rhd_add_donation_meta_boxes()
{
	add_meta_box(
		'rhd_donation_classy_url',
		__( 'Classy Donation Page URL' ),
		'rhd_donation_classy_url_callback',
		'donation_page',
		'normal',
		'high'
	);

	add_meta_box(
		'rhd_donation_intro',
		__( 'Donation Intro', 'rhd' ),
		'rhd_donation_intro_callback',
		'donation_page',
		'normal',
		'high'
	);

	add_meta_box(
		'rhd_donation_amounts',
		__( 'Donation Amounts', 'rhd' ),
		'rhd_donation_amounts_callback',
		'donation_page',
		'normal',
		'high'
	);

	add_meta_box(
		'rhd_donation_allocations',
		__( 'Donation Allocations', 'rhd' ),
		'rhd_donation_allocations_callback',
		'donation_page',
		'normal',
		'high'
	);

	add_meta_box(
		'rhd_donation_full_header',
		__( 'Full-Width Header', 'rhd' ),
		'rhd_donation_full_header_callback',
		'donation_page',
		'side',
		'low'
	);
}
add_action( 'add_meta_boxes', 'rhd_add_donation_meta_boxes' );



/**
 * rhd_donation_classy_url_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_donation_classy_url_callback( $post )
{
	wp_nonce_field( 'rhd_donation_classy_url_meta_box', 'rhd_donation_classy_url_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<p>
		<label for="rhd-donation-classy-url" class="rhd-donation-classy-url"><?php _e( 'Classy URL: ', 'rhd' ); ?></label><input type="url" name="rhd-donation-classy-url" style="width: 100%;" value="<?php if ( isset ( $meta['_donation_classy_url'] ) ) echo $meta['_donation_classy_url'][0]; ?>">
	</p>
<?php
}


/**
 * rhd_donation_intro_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_donation_intro_callback( $post )
{
	wp_nonce_field( 'rhd_donation_intro_meta_box', 'rhd_donation_intro_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<p>
		<label for="rhd-donation-headline" class="rhd-donation-headline"><?php _e( 'Donation Headline: ', 'rhd' ); ?></label><input type="text" name="rhd-donation-headline" style="width: 100%;" value="<?php if ( isset ( $meta['_donation_headline'] ) ) echo $meta['_donation_headline'][0]; ?>">
	</p>
	<p>
		<label for="rhd-donation-intro" class="rhd-donation-intro"><?php _e( 'Introductory Text: ', 'rhd' ); ?></label>
		<textarea name="rhd-donation-intro" style="width: 100%;"><?php if ( isset ( $meta['_donation_intro'] ) ) echo $meta['_donation_intro'][0]; ?></textarea>
	</p>
<?php
}


/**
 * rhd_donation_amounts_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_donation_amounts_callback( $post )
{
	wp_nonce_field( 'rhd_donation_amounts_meta_box', 'rhd_donation_amounts_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<table id="donation-amounts">
		<thead>
			<th>Amount (without $)</th>
		</thead>

		<?php for ( $i = 1; $i <= RHD_DONATION_BOXES; ++$i ) : ?>
			<tr>
				<td>
					<input type="number" name="rhd-donation-amount-<?php echo $i; ?>" id="rhd-donation-amount-<?php echo $i; ?>" value="<?php if ( isset ( $meta['_donation_amount_' . $i] ) ) echo $meta['_donation_amount_' . $i][0]; ?>" />
				</td>
			</tr>
		<?php endfor; ?>
	</table>
<?php
}


/**
 * rhd_donation_allocations_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_donation_allocations_callback( $post )
{
	wp_nonce_field( 'rhd_donation_allocations_meta_box', 'rhd_donation_allocations_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<table id="donation-allocations">
		<thead>
			<th>Label/Amount</th>
			<th>Description</th>
		</thead>
		<?php for ( $i = 1; $i <= RHD_ALLOCATION_BOXES; ++$i ) : ?>
			<tr>
				<td>
					<input type="text" name="rhd-donation-allocation-amount-<?php echo $i; ?>" id="rhd-donation-allocation-amount-<?php echo $i; ?>" value="<?php if ( isset ( $meta['_donation_allocation_amount_' . $i] ) ) echo $meta['_donation_allocation_amount_' . $i][0]; ?>" />
				</td>
				<td>
					<input type="text" name="rhd-donation-allocation-text-<?php echo $i; ?>" id="rhd-donation-allocation-text-<?php echo $i; ?>" value="<?php if ( isset ( $meta['_donation_allocation_text_' . $i] ) ) echo $meta['_donation_allocation_text_' . $i][0]; ?>" />
				</td>
			</tr>
		<?php endfor; ?>
	</table>
<?php
}


/**
 * rhd_donation_full_header_callback function.
 *
 * @access public
 * @param mixed $post
 * @return void
 */
function rhd_donation_full_header_callback( $post )
{
	wp_nonce_field( 'rhd_donation_full_header_meta_box', 'rhd_donation_full_header_meta_box_nonce' );

	$meta = get_post_meta( $post->ID );
?>

	<p>
		<label for="rhd-donation-full-header" class="rhd-donation-full-header"><input type="checkbox" id="rhd-donation-full-header" name="rhd-donation-full-header" value="yes" <?php if ( isset ( $meta['_donation_full_header'] ) ) checked( $meta['_donation_full_header'][0], 'yes' ); ?>><?php _e( 'Use the Featured Image (above) as a full-width header.', 'rhd' ); ?></label>
	</p>
<?php
}


/**
 * rhd_save_donation_meta_box_data function.
 *
 * @access public
 * @param mixed $post_id
 * @return void
 */
function rhd_save_donation_meta_box_data( $post_id )
{
	// Check if our nonces are set.
	if (
		! isset( $_POST['rhd_donation_classy_url_meta_box_nonce'] ) ||
		! isset( $_POST['rhd_donation_intro_meta_box_nonce'] ) ||
		! isset( $_POST['rhd_donation_amounts_meta_box_nonce'] ) ||
		! isset( $_POST['rhd_donation_allocations_meta_box_nonce' ] ) ||
		! isset( $_POST['rhd_donation_full_header_meta_box_nonce' ] )
	) {
		return;
	}

	// Verify that the nonces are valid.
	if (
		! wp_verify_nonce( $_POST['rhd_donation_classy_url_meta_box_nonce'], 'rhd_donation_classy_url_meta_box' ) ||
		! wp_verify_nonce( $_POST['rhd_donation_intro_meta_box_nonce'], 'rhd_donation_intro_meta_box' ) ||
		! wp_verify_nonce( $_POST['rhd_donation_amounts_meta_box_nonce'], 'rhd_donation_amounts_meta_box' ) ||
		! wp_verify_nonce( $_POST['rhd_donation_allocations_meta_box_nonce'], 'rhd_donation_allocations_meta_box' ) ||
		! wp_verify_nonce( $_POST['rhd_donation_full_header_meta_box_nonce'], 'rhd_donation_full_header_meta_box' )
	) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'donation_page' == $_POST['post_type'] ) {

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
	if( isset( $_POST['rhd-donation-classy-url'] ) ) {
		$safe = esc_url( $_POST['rhd-donation-classy-url'] );
		update_post_meta( $post_id, '_donation_classy_url', $safe );
	}

	for ( $i = 1; $i <= RHD_DONATION_BOXES; ++$i ) {
		if( isset( $_POST["rhd-donation-amount-$i"] ) ) {
			$safe = absint( $_POST["rhd-donation-amount-$i"] );
			update_post_meta( $post_id, "_donation_amount_$i", $safe );
		}
	}

	for ( $i = 1; $i <= RHD_ALLOCATION_BOXES; ++$i ) {
		if( isset( $_POST["rhd-donation-allocation-amount-$i"] ) ) {
			$safe = esc_html( $_POST["rhd-donation-allocation-amount-$i"] );
			update_post_meta( $post_id, "_donation_allocation_amount_$i", $safe );
		}

		if( isset( $_POST["rhd-donation-allocation-text-$i"] ) ) {
			$safe = esc_html( $_POST["rhd-donation-allocation-text-$i"] );
			update_post_meta( $post_id, "_donation_allocation_text_$i", $safe );
		}
	}

	if( isset( $_POST['rhd-donation-intro'] ) ) {
		$safe = esc_html( $_POST['rhd-donation-intro'] );
		update_post_meta( $post_id, '_donation_intro', $safe );
	}

	if( isset( $_POST['rhd-donation-headline'] ) ) {
		$safe = esc_html( $_POST['rhd-donation-headline'] );
		update_post_meta( $post_id, '_donation_headline', $safe );
	}

	if ( isset( $_POST['rhd-donation-full-header'] ) ) {
		update_post_meta( $post_id, '_donation_full_header', 'yes' );
	} else {
		update_post_meta( $post_id, '_donation_full_header', '' );
	}
}
add_action( 'save_post', 'rhd_save_donation_meta_box_data' );


/**
 * rhd_cpt_post_types function.
 *
 * @access public
 * @param mixed $post_types
 * @return void
 */
function rhd_cpt_post_types( $post_types )
{
	$post_types[] = 'donation_page';
	return $post_types;
}
add_filter( 'cpt_post_types', 'rhd_cpt_post_types' );


/**
 * rhd_donation_headline function.
 *
 * @access public
 * @return void
 */
function rhd_donation_headline()
{
	global $post;
	$meta_text = get_post_meta( $post->ID, '_donation_headline', true );
	echo ( $meta_text != '' ) ? esc_html( $meta_text ) : 'Support Our Patients';
}


/**
 * rhd_donation_intro_text function.
 *
 * @access public
 * @return void
 */
function rhd_donation_intro_text()
{
	global $post;
	$meta_text = get_post_meta( $post->ID, '_donation_intro', true );
	echo apply_filters( 'the_content', $meta_text );
}


/**
 * rhd_donation_page_sidebar function.
 *
 * @access public
 * @return void
 */
function rhd_donation_allocations()
{
	global $post;
	$meta = get_post_meta( $post->ID );
	?>
	<div class="widget widget-donation_page rhd-donation-allocations-widget">
		<table id="donation-allocations-table">
			<?php for ( $i = 1; $i <= RHD_ALLOCATION_BOXES; ++$i ) : ?>
				<?php
				$amt_key = "_donation_allocation_amount_$i";
				$text_key = "_donation_allocation_text_$i";
				?>

				<?php if ( $meta[$amt_key][0] != '' && $meta[$text_key][0] != '' ) : ?>
					<tr>
						<td class="donation-allocation-amount"><?php echo esc_html( $meta[$amt_key][0] ); ?></td>
						<td class="donation-allocation-text"><?php echo esc_html( $meta[$text_key][0] ); ?></td>
					</tr>
				<?php endif; ?>
			<?php endfor; ?>
		</table>
	</div>
	<?php
}


/**
 * rhd_donation_form function.
 *
 * @access public
 * @return void
 */
function rhd_donation_form()
{
	global $post;
	$meta = get_post_meta( $post->ID );
	?>

	<form id="donation-form" action="<?php echo home_url('/donation'); ?>" method="get">
		<fieldset>
			<legend class="donation-select-label">How much would you like to donate?</legend>
			<ul>
				<?php for ( $i = 1; $i <= RHD_DONATION_BOXES; ++$i ) : ?>
					<?php if ( $meta["_donation_amount_$i"] != '' ) : ?>
						<li class="donation-selector">
							<button type="button" class="donation-set-amount" name="donation-amount-<?php echo $i; ?>" id="donation-amount-<?php echo $i; ?>" value="<?php echo $meta["_donation_amount_$i"][0]; ?>"><?php echo '$' . number_format( esc_html( $meta["_donation_amount_$i"][0] ) ); ?></button>
						</li>
					<?php endif; ?>
				<?php endfor; ?>
			</ul>
			<div id="donation-custom-amount-container">
				<span class="donation-custom-amount-currency">$</span><input type="text" id="donation-custom-amount" name="amount" value="" data-an-default="" placeholder="Your Amount">
			</div>
		</fieldset>
		<br />
		<fieldset>
			<label for="one-time" class="donation-recur"><input type="radio" id="one-time" name="recurring" value="0" checked>One-time</label>
			<label for="monthly" class="donation-recur"><input type="radio" id="monthly" name="recurring" value="1">Monthly</label>
		</fieldset>
		<input type="hidden" name="classy-url" id="classy-url" value="<?php echo $meta['_donation_classy_url'][0]; ?>">
		<input type="submit" value="Donate Now" id="donate-submit">
	</form>

	<?php
}