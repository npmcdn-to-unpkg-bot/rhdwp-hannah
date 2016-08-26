<?php
/**
 * RHD Site Settings
 *
 * Admin Settings Page (starter)
 */
class RHD_Settings
{
	/**
	* Holds the values to be used in the fields callbacks
	*/
	private $options;

	/**
	* Start up
	*/
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'rhd_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'rhd_register_settings' ) );
	}

	/**
	* Add options page
	*/
	public function rhd_admin_menu() {
		add_submenu_page( 'options-general.php', 'RHD Site Settings', 'RHD Site Settings', 'manage_options', 'rhd_settings', array( $this, 'create_admin_page' ) );
	}

	/**
	* Options page callback
	*/
	public function create_admin_page() {
		// Set class property
		$this->general = get_option( 'rhd_general_options' );
		$this->display = get_option( 'rhd_display_options' );
	?>
	<div class="wrap">
		<h2>RHD Site Settings</h2>
		<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'rhd_site_settings' );
				settings_fields( 'rhd_display_settings' );
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
	public function rhd_register_settings() {
		register_setting(
			'rhd_site_settings', // Option group
			'rhd_general_options', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		register_setting(
			'rhd_display_settings',
			'rhd_display_options',
			array( $this, 'sanitize' )
		);

		add_settings_section(
			'rhd_display_options_settings',
			'Display Options',
			array( $this, 'print_display_options_settings_section_info' ),
			'rhd-settings-admin'
		);

		add_settings_field(
			'rhd_display_options',
			'Enable Parallax Effects',
			array( $this, 'display_options_cb' ),
			'rhd-settings-admin',
			'rhd_display_options_settings'
		);

		add_settings_section(
			'rhd_custom_data_settings',
			get_bloginfo( 'name' ) . ' Options',
			array( $this, 'print_custom_data_info' ),
			'rhd-settings-admin'
		);

		add_settings_field(
			'rhd_custom_data_contact',
			"Contact Information <br /> (HTML tags allowed): ",
			array( $this, 'rhd_custom_data_contact_cb' ),
			'rhd-settings-admin',
			'rhd_custom_data_settings'
		);
	}

	/**
	* Sanitize each setting field as needed
	*
	* @param array $input Contains all settings fields as array keys
	*/
	public function sanitize( $input )
	{
		$new_input = array();

		$new_input['rhd_enable_parallax'] = ( isset( $input['rhd_enable_parallax'] ) ) ? 'yes' : '';
		$new_input['rhd_enable_ajax_pagination'] = ( isset( $input['rhd_enable_ajax_pagination'] ) ) ? 'yes' : '';

		$new_input['rhd_custom_data_contact_html'] = ( isset( $input['rhd_custom_data_contact_html'] ) ) ? wp_kses_post( $input['rhd_custom_data_contact_html'] ) : '';

		return $new_input;
	}

	/**
	* Print the Section text
	*/
	public function print_display_options_settings_section_info() {
		echo '<p>Site-wide display options. Please confirm with <a href="mailto:admin@roundhouse-designs.com">Roundhouse Designs</a> before altering these settings.</p>';
	}

	public function print_custom_data_info()
	{
		print '<p></p>';
	}

	/**
	* Input callbacks
	*/
	public function rhd_custom_data_contact_cb( $args )
	{
		printf(
			'<textarea id="rhd_custom_data_contact_html" name="rhd_general_options[rhd_custom_data_contact_html]" cols="60" rows="7">%s</textarea>',
			isset( $this->display['rhd_custom_data_contact_html'] ) ? $this->display['rhd_custom_data_contact_html'] : ''
		);
	}

	public function display_options_cb( $args ) {
		$output = '<p><input type="checkbox" id="rhd_enable_parallax" name="rhd_display_options[rhd_enable_parallax]" value="yes" ' . checked( 'yes', $this->general['rhd_enable_parallax'], false ) . ' />
			<label for="rhd_enable_parallax">Enable [big-image] parallax effects</label></p>';

		$output .= '<p><input type="checkbox" id="rhd_enable_ajax_pagination" name="rhd_display_options[rhd_enable_ajax_pagination]" value="yes" ' . checked( 'yes', $this->general['rhd_enable_ajax_pagination'], false ) . ' />
			<label for="rhd_enable_ajax_pagination">Enable base AJAX post functionality</label></p>';

		echo $output;
	}
}

if( is_admin() )
	$rhd_settings_page = new RHD_Settings();
