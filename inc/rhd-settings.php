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
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'rhd_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'rhd_register_settings' ) );
	}

	/**
	* Add options page
	*/
	public function rhd_admin_menu()
	{
		add_submenu_page( 'options-general.php', 'RHD Site Settings', 'RHD Site Settings', 'manage_options', 'rhd_settings', array( $this, 'create_admin_page' ) );
	}

	/**
	* Options page callback
	*/
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'rhd_general_options' );
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
	public function rhd_register_settings()
	{
		register_setting(
			'rhd_site_settings', // Option group
			'rhd_general_options', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		/*
		add_settings_section(
			'rhd_sample_button_settings',
			'Sample Buttons',
			array( $this, 'print_sample_buttons_section_info' ),
			'rhd-settings-admin'
		);

		add_settings_field(
			'rhd_button_1',
			'Sample Button 1: ',
			array( $this, 'button_1_cb' ),
			'rhd-settings-admin',
			'rhd_sample_button_settings'
		);
		*/
	}

	/**
	* Sanitize each setting field as needed
	*
	* @param array $input Contains all settings fields as array keys
	*/
	public function sanitize( $input )
	{
		$new_input = array();

		$new_input['rhd_button_1_label'] = ( isset( $input['rhd_button_1_label'] ) ) ? sanitize_text_field( $input['rhd_button_1_label'] ) : '';
		$new_input['rhd_button_1_sub'] = ( isset( $input['rhd_button_1_sub'] ) ) ? sanitize_text_field( $input['rhd_button_1_sub'] ) : '';
		$new_input['rhd_button_1_link'] = ( isset( $input['rhd_button_1_link'] ) ) ? esc_url_raw( $input['rhd_button_1_link'] ) : '';
		$new_input['rhd_button_1_text'] = ( isset( $input['rhd_button_1_text'] ) ) ? wp_kses_post( $input['rhd_button_1_text'] ) : '';

		return $new_input;
	}

	/**
	* Print the Section text
	*/
	public function print_sample_buttons_section_info()
	{
		print '<p>Some sample inputs.</p>';
	}

	/**
	* Input callbacks
	*/
	public function button_1_cb( $args )
	{
		printf(
			'<p><label for="rhd_button_1_label">Label</label><br />
			<input type="text" id="rhd_button_1_label" name="rhd_general_options[rhd_button_1_label]" value="%s" /></p>',
			isset( $this->options['rhd_button_1_label'] ) ? $this->options['rhd_button_1_label'] : ''
		);

		printf(
			'<p><label for="rhd_button_1_sub">Subtitle</label><br />
			<input type="text" id="rhd_button_1_sub" name="rhd_general_options[rhd_button_1_sub]" class="widefat"  value="%s" /></p>',
			isset( $this->options['rhd_button_1_sub'] ) ? $this->options['rhd_button_1_sub'] : ''
		);

		printf(
			'<p><label for="rhd_button_1_link">Link</label><br />
			<input type="url" id="rhd_button_1_link" name="rhd_general_options[rhd_button_1_link]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_button_1_link'] ) ? $this->options['rhd_button_1_link'] : ''
		);
		echo '</p>';

		printf(
			'<p><label for="rhd_button_1_text">Text/Description (HTML tags allowed)</label><br />
			<textarea id="rhd_button_1_text" name="rhd_general_options[rhd_button_1_text]" class="widefat" rows="5">%s</textarea></p>',
			isset( $this->options['rhd_button_1_text'] ) ? $this->options['rhd_button_1_text'] : ''
		);
	}
}

if( is_admin() )
	$rhd_settings_page = new RHD_Settings();
