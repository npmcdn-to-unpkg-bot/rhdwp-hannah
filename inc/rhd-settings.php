<?php
/**
 * RHD Site Settings
 *
 * Admin Settings Page (starter)
 */

$options = get_option( 'rhd_site_settings' );

/**
* Add options page
*/
function rhd_admin_menu() {
	add_submenu_page( 'options-general.php', 'RHD Site Settings', 'RHD Site Settings', 'manage_options', 'rhd_settings', 'create_admin_page' );
}
add_action( 'admin_menu', 'rhd_admin_menu' );

/**
* Options page callback
*/
function create_admin_page() {
	?>
	<div class="wrap">
		<h2>RHD Site Settings</h2>
		<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'rhd_site_settings' );
				do_settings_sections( 'rhd-settings-admin' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
* Register and add settings
*/
function rhd_register_settings() {
	register_setting(
		'rhd_site_settings', // Option group
		'rhd_site_settings', // Option name
		'sanitize' // Sanitize
	);

	add_settings_section(
		'rhd_display_options_settings',
		'Display Settings',
		'print_display_options_settings_section_info',
		'rhd-settings-admin'
	);

	add_settings_field(
		'rhd_display_options',
		'Options',
		'display_options_cb',
		'rhd-settings-admin',
		'rhd_display_options_settings'
	);

	add_settings_section(
		'rhd_custom_data',
		get_bloginfo( 'name' ) . ' Custom Data',
		'print_custom_data_section_info',
		'rhd-settings-admin'
	);

	add_settings_field(
		'rhd_custom_data_address',
		'Business Contact',
		'custom_data_address_cb',
		'rhd-settings-admin',
		'rhd_custom_data'
	);
}
add_action( 'admin_init', 'rhd_register_settings' );

/**
* Sanitize each setting field as needed
*
* @param array $input Contains all settings fields as array keys
*/
function sanitize( $input )
{
	$new_input = array();

	$new_input['enable_parallax'] = ( $input['enable_parallax'] == 'yes' ) ? 'yes' : '';
	$new_input['enable_ajax_pagination'] = ( $input['enable_ajax_pagination'] == 'yes' ) ? 'yes' : '';

	$new_input['custom_data_address'] = ( isset( $input['custom_data_address'] ) ) ? wp_kses_data( $input['custom_data_address'] ) : '';
	$new_input['custom_data_email'] = ( isset( $input['custom_data_email'] ) ) ? sanitize_email( $input['custom_data_email'] ) : '';

	$new_input['rhd_button_1_label'] = ( isset( $input['rhd_button_1_label'] ) ) ? sanitize_text_field( $input['rhd_button_1_label'] ) : '';
	$new_input['rhd_button_1_sub'] = ( isset( $input['rhd_button_1_sub'] ) ) ? sanitize_text_field( $input['rhd_button_1_sub'] ) : '';
	$new_input['rhd_button_1_link'] = ( isset( $input['rhd_button_1_link'] ) ) ? esc_url_raw( $input['rhd_button_1_link'] ) : '';
	$new_input['rhd_button_1_text'] = ( isset( $input['rhd_button_1_text'] ) ) ? wp_kses_post( $input['rhd_button_1_text'] ) : '';

	return $new_input;
}

/**
* Print the Section text
*/
function print_display_options_settings_section_info() {
	echo '<p>Changing display options <strong>may break your site</strong>. Please confirm with <a href="mailto:admin@roundhouse-designs.com">Roundhouse Designs</a> before altering these settings.</p>';
}

function print_custom_data_section_info() {
	echo '<p></p>';
}

/**
* Input callbacks
*/
function display_options_cb( $args ) {
	global $options;

	$output = '<p><input type="checkbox" id="enable_parallax" name="rhd_site_settings[enable_parallax]" value="yes" ' . checked( 'yes', $options['enable_parallax'], false ) . ' />
		<label for="enable_parallax">Enable [big-image] parallax effects</label></p>';

	$output .= '<p><input type="checkbox" id="enable_ajax_pagination" name="rhd_site_settings[enable_ajax_pagination]" value="yes" ' . checked( 'yes', $options['enable_ajax_pagination'], false ) . ' />
		<label for="enable_ajax_pagination">Enable base AJAX post functionality</label></p>';

	echo $output;
}


function custom_data_address_cb( $args ) {
	global $options;

	$output = '<p>
				<label for="custom_data_address">Basic HTML allowed</label><br />
				<textarea id="custom_data_address" name="rhd_site_settings[custom_data_address]" rows="7" cols="70">' . $options['custom_data_address'] . '</textarea>
				</p>';

	$output .= '<p>
				<label for="custom_data_email">Contact Email</label>
				<input id="custom_data_email" name="rhd_site_settings[custom_data_email]" class="widefat" value="' . $options['custom_data_email'] . '" />
				</p>';

	echo $output;
}