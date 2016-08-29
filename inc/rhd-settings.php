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
		'rhd_display_options',
		'Display Settings',
		'print_display_options_settings_section_info',
		'rhd-settings-admin'
	);

	add_settings_field(
		'rhd_display_options',
		'Options',
		'display_options_cb',
		'rhd-settings-admin',
		'rhd_display_options'
	);

	/*
	add_settings_section(
		'rhd_sample_button_settings',
		'Sample Buttons',
		'print_sample_buttons_section_info',
		'rhd-settings-admin'
	);

	add_settings_field(
		'rhd_button_1',
		'Sample Button 1: ',
		'button_1_cb',
		'rhd-settings-admin',
		'rhd_sample_button_settings'
	);
	*/
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

function print_sample_buttons_section_info() {
	echo '<p>Some sample inputs.</p>';
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


function button_1_cb( $args ) {
	global $options;

	printf(
		'<p><label for="rhd_button_1_label">Label</label><br />
		<input type="text" id="rhd_button_1_label" name="rhd_site_settings[rhd_button_1_label]" value="%s" /></p>',
		isset( $options['rhd_button_1_label'] ) ? $options['rhd_button_1_label'] : ''
	);

	printf(
		'<p><label for="rhd_button_1_sub">Subtitle</label><br />
		<input type="text" id="rhd_button_1_sub" name="rhd_site_settings[rhd_button_1_sub]" class="widefat"  value="%s" /></p>',
		isset( $options['rhd_button_1_sub'] ) ? $options['rhd_button_1_sub'] : ''
	);

	printf(
		'<p><label for="rhd_button_1_link">Link</label><br />
		<input type="url" id="rhd_button_1_link" name="rhd_site_settings[rhd_button_1_link]" class="widefat" value="%s" /></p>',
		isset( $options['rhd_button_1_link'] ) ? $options['rhd_button_1_link'] : ''
	);
	echo '</p>';

	printf(
		'<p><label for="rhd_button_1_text">Text/Description (HTML tags allowed)</label><br />
		<textarea id="rhd_button_1_text" name="rhd_site_settings[rhd_button_1_text]" class="widefat" rows="5">%s</textarea></p>',
		isset( $options['rhd_button_1_text'] ) ? $options['rhd_button_1_text'] : ''
	);
}