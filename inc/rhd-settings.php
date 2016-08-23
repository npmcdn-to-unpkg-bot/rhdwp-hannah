<?php
/**
 * RHD Theme Settings
 *
 * Admin Settings Page
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
		add_submenu_page( 'options-general.php', 'SF Site Settings', 'SF Site Settings', 'manage_options', 'rhd_settings', array( $this, 'create_admin_page' ) );
	}

	/**
	* Options page callback
	*/
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'rhd_site_settings' );
	?>
	<div class="wrap">
		<h2>Stanislaus Futures Theme Settings</h2>
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
			'rhd_site_settings', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'rhd_cta_button_settings',
			'Call to Action Buttons',
			array( $this, 'print_cta_buttons_section_info' ),
			'rhd-settings-admin'
		);

		add_settings_section(
			'rhd_donate_cta_settings',
			'Donation CTA',
			array( $this, 'print_donate_cta_section_info' ),
			'rhd-settings-admin'
		);

		add_settings_field(
			'rhd_button_1',
			'Button 1: ',
			array( $this, 'button_1_cb' ),
			'rhd-settings-admin',
			'rhd_cta_button_settings'
		);

		add_settings_field(
			'rhd_button_2',
			'Button 2: ',
			array( $this, 'button_2_cb' ),
			'rhd-settings-admin',
			'rhd_cta_button_settings'
		);

		add_settings_field(
			'rhd_button_3',
			'Button 3: ',
			array( $this, 'button_3_cb' ),
			'rhd-settings-admin',
			'rhd_cta_button_settings'
		);

		add_settings_field(
			'rhd_donate_cta_1',
			'Area 1: ',
			array( $this, 'donate_cta_area_1_cb' ),
			'rhd-settings-admin',
			'rhd_donate_cta_settings'
		);

		add_settings_field(
			'rhd_donate_cta_2',
			'Area 2: ',
			array( $this, 'donate_cta_area_2_cb' ),
			'rhd-settings-admin',
			'rhd_donate_cta_settings'
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

		$new_input['rhd_button_1_label'] = ( isset( $input['rhd_button_1_label'] ) ) ? sanitize_text_field( $input['rhd_button_1_label'] ) : '';
		$new_input['rhd_button_1_sub'] = ( isset( $input['rhd_button_1_sub'] ) ) ? sanitize_text_field( $input['rhd_button_1_sub'] ) : '';
		$new_input['rhd_button_1_link'] = ( isset( $input['rhd_button_1_link'] ) ) ? esc_url_raw( $input['rhd_button_1_link'] ) : '';
		$new_input['rhd_button_1_text'] = ( isset( $input['rhd_button_1_text'] ) ) ? wp_kses_post( $input['rhd_button_1_text'] ) : '';

		$new_input['rhd_button_2_label'] = ( isset( $input['rhd_button_2_label'] ) ) ? sanitize_text_field( $input['rhd_button_2_label'] ) : '';
		$new_input['rhd_button_2_sub'] = ( isset( $input['rhd_button_2_sub'] ) ) ? sanitize_text_field( $input['rhd_button_2_sub'] ) : '';
		$new_input['rhd_button_2_link'] = ( isset( $input['rhd_button_2_link'] ) ) ? esc_url_raw( $input['rhd_button_2_link'] ) : '';
		$new_input['rhd_button_2_text'] = ( isset( $input['rhd_button_2_text'] ) ) ? wp_kses_post( $input['rhd_button_2_text'] ) : '';

		$new_input['rhd_button_3_label'] = ( isset( $input['rhd_button_3_label'] ) ) ? sanitize_text_field( $input['rhd_button_3_label'] ) : '';
		$new_input['rhd_button_3_sub'] = ( isset( $input['rhd_button_3_sub'] ) ) ? sanitize_text_field( $input['rhd_button_3_sub'] ) : '';
		$new_input['rhd_button_3_link'] = ( isset( $input['rhd_button_3_link'] ) ) ? esc_url_raw( $input['rhd_button_3_link'] ) : '';
		$new_input['rhd_button_3_text'] = ( isset( $input['rhd_button_3_text'] ) ) ? wp_kses_post( $input['rhd_button_3_text'] ) : '';

		$new_input['rhd_donate_cta_area_1_heading'] = ( isset( $input['rhd_donate_cta_area_1_heading'] ) ) ? strip_tags( $input['rhd_donate_cta_area_1_heading'], '<br>' ) : '';
		$new_input['rhd_donate_cta_area_1_content'] = ( isset( $input['rhd_donate_cta_area_1_content'] ) ) ? wp_kses_post( $input['rhd_donate_cta_area_1_content'] ) : '';
		$new_input['rhd_donate_cta_area_1_button_label'] = ( isset( $input['rhd_donate_cta_area_1_button_label'] ) ) ? sanitize_text_field( $input['rhd_donate_cta_area_1_button_label'] ) : '';
		$new_input['rhd_donate_cta_area_1_button_link'] = ( isset( $input['rhd_donate_cta_area_1_button_link'] ) ) ? esc_url_raw( $input['rhd_donate_cta_area_1_button_link'] ) : '';

		$new_input['rhd_donate_cta_area_2_heading'] = ( isset( $input['rhd_donate_cta_area_2_heading'] ) ) ? strip_tags( $input['rhd_donate_cta_area_2_heading'], '<br>' ) : '';
		$new_input['rhd_donate_cta_area_2_content'] = ( isset( $input['rhd_donate_cta_area_2_content'] ) ) ? wp_kses_post( $input['rhd_donate_cta_area_2_content'] ) : '';
		$new_input['rhd_donate_cta_area_2_button_label'] = ( isset( $input['rhd_donate_cta_area_2_button_label'] ) ) ? sanitize_text_field( $input['rhd_donate_cta_area_2_button_label'] ) : '';
		$new_input['rhd_donate_cta_area_2_button_link'] = ( isset( $input['rhd_donate_cta_area_2_button_link'] ) ) ? esc_url_raw( $input['rhd_donate_cta_area_2_button_link'] ) : '';

		return $new_input;
	}

	/**
	* Print the Section text
	*/
	public function print_cta_buttons_section_info()
	{
		print '<p>This section controls the blue CTA buttons found throughout the site.</p>';
	}

	public function print_donate_cta_section_info()
	{
		print '<p>This section controls the content for the blue call to action areas on the Donate page (and where else the [donate-cta] shortcode is used).</p>';
	}

	/**
	* Input callbacks
	*/
	public function button_1_cb( $args )
	{
		printf(
			'<p><label for="rhd_button_1_label">Label</label><br />
			<input type="text" id="rhd_button_1_label" name="rhd_site_settings[rhd_button_1_label]" value="%s" /></p>',
			isset( $this->options['rhd_button_1_label'] ) ? $this->options['rhd_button_1_label'] : ''
		);

		printf(
			'<p><label for="rhd_button_1_sub">Subtitle</label><br />
			<input type="text" id="rhd_button_1_sub" name="rhd_site_settings[rhd_button_1_sub]" class="widefat"  value="%s" /></p>',
			isset( $this->options['rhd_button_1_sub'] ) ? $this->options['rhd_button_1_sub'] : ''
		);

		printf(
			'<p><label for="rhd_button_1_link">Link</label><br />
			<input type="url" id="rhd_button_1_link" name="rhd_site_settings[rhd_button_1_link]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_button_1_link'] ) ? $this->options['rhd_button_1_link'] : ''
		);
		echo '</p>';

		printf(
			'<p><label for="rhd_button_1_text">Text/Description (HTML tags allowed)</label><br />
			<textarea id="rhd_button_1_text" name="rhd_site_settings[rhd_button_1_text]" class="widefat" rows="5">%s</textarea></p>',
			isset( $this->options['rhd_button_1_text'] ) ? $this->options['rhd_button_1_text'] : ''
		);
	}


	public function button_2_cb( $args )
	{
		printf(
			'<p><label for="rhd_button_2_label">Label</label><br />
			<input type="text" id="rhd_button_2_label" name="rhd_site_settings[rhd_button_2_label]" value="%s" /></p>',
			isset( $this->options['rhd_button_2_label'] ) ? $this->options['rhd_button_2_label'] : ''
		);

		printf(
			'<p><label for="rhd_button_2_sub">Subtitle</label><br />
			<input type="text" id="rhd_button_2_sub" name="rhd_site_settings[rhd_button_2_sub]" class="widefat"  value="%s" /></p>',
			isset( $this->options['rhd_button_2_sub'] ) ? $this->options['rhd_button_2_sub'] : ''
		);

		printf(
			'<p><label for="rhd_button_2_link">Link</label><br />
			<input type="url" id="rhd_button_2_link" name="rhd_site_settings[rhd_button_2_link]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_button_2_link'] ) ? $this->options['rhd_button_2_link'] : ''
		);
		echo '</p>';

		printf(
			'<p><label for="rhd_button_2_text">Text/Description (HTML tags allowed) (HTML tags allowed)</label><br />
			<textarea id="rhd_button_2_text" name="rhd_site_settings[rhd_button_2_text]" class="widefat" rows="5">%s</textarea></p>',
			isset( $this->options['rhd_button_2_text'] ) ? $this->options['rhd_button_2_text'] : ''
		);
	}


	public function button_3_cb( $args )
	{
		printf(
			'<p><label for="rhd_button_3_label">Label</label><br />
			<input type="text" id="rhd_button_3_label" name="rhd_site_settings[rhd_button_3_label]" value="%s" /></p>',
			isset( $this->options['rhd_button_3_label'] ) ? $this->options['rhd_button_3_label'] : ''
		);

		printf(
			'<p><label for="rhd_button_3_sub">Subtitle</label><br />
			<input type="text" id="rhd_button_3_sub" name="rhd_site_settings[rhd_button_3_sub]" class="widefat"  value="%s" /></p>',
			isset( $this->options['rhd_button_3_sub'] ) ? $this->options['rhd_button_3_sub'] : ''
		);

		printf(
			'<p><label for="rhd_button_3_link">Link</label><br />
			<input type="url" id="rhd_button_3_link" name="rhd_site_settings[rhd_button_3_link]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_button_3_link'] ) ? $this->options['rhd_button_3_link'] : ''
		);
		echo '</p>';

		printf(
			'<p><label for="rhd_button_3_text">Text/Description (HTML tags allowed)</label><br />
			<textarea id="rhd_button_3_text" name="rhd_site_settings[rhd_button_3_text]" class="widefat" rows="5">%s</textarea></p>',
			isset( $this->options['rhd_button_3_text'] ) ? $this->options['rhd_button_3_text'] : ''
		);
	}


	public function donate_cta_area_1_cb( $args )
	{
		printf(
			'<p><label for="rhd_donate_cta_area_1_heading">Heading (HTML line breaks only)</label><br />
			<input type="text" id="rhd_donate_cta_area_1_heading" name="rhd_site_settings[rhd_donate_cta_area_1_heading]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_donate_cta_area_1_heading'] ) ? $this->options['rhd_donate_cta_area_1_heading'] : ''
		);

		printf(
			'<p><label for="rhd_donate_cta_area_1_content">Text (HTML is allowed)</label><br />
			<textarea id="rhd_donate_cta_area_1_content" name="rhd_site_settings[rhd_donate_cta_area_1_content]" class="widefat" rows="5">%s</textarea>',
			isset( $this->options['rhd_donate_cta_area_1_content'] ) ? $this->options['rhd_donate_cta_area_1_content'] : ''
		);

		printf(
			'<p><label for="rhd_donate_cta_area_1_button_label">Button Label</label><br />
			<input type="text" id="rhd_donate_cta_area_1_button_label" name="rhd_site_settings[rhd_donate_cta_area_1_button_label]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_donate_cta_area_1_button_label'] ) ? $this->options['rhd_donate_cta_area_1_button_label'] : ''
		);

		printf(
			'<p><label for="rhd_donate_cta_area_1_button_link">Button Link</label><br />
			<input type="url" id="rhd_donate_cta_area_1_button_link" name="rhd_site_settings[rhd_donate_cta_area_1_button_link]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_donate_cta_area_1_button_link'] ) ? $this->options['rhd_donate_cta_area_1_button_link'] : ''
		);
	}


	public function donate_cta_area_2_cb( $args )
	{
		printf(
			'<p><label for="rhd_donate_cta_area_2_heading">Heading (HTML line breaks only)</label><br />
			<input type="text" id="rhd_donate_cta_area_2_heading" name="rhd_site_settings[rhd_donate_cta_area_2_heading]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_donate_cta_area_2_heading'] ) ? $this->options['rhd_donate_cta_area_2_heading'] : ''
		);

		printf(
			'<p><label for="rhd_donate_cta_area_2_content">Text (HTML is allowed)</label><br />
			<textarea id="rhd_donate_cta_area_2_content" name="rhd_site_settings[rhd_donate_cta_area_2_content]" class="widefat" rows="5">%s</textarea>',
			isset( $this->options['rhd_donate_cta_area_2_content'] ) ? $this->options['rhd_donate_cta_area_2_content'] : ''
		);

		printf(
			'<p><label for="rhd_donate_cta_area_2_button_label">Button Label</label><br />
			<input type="text" id="rhd_donate_cta_area_2_button_label" name="rhd_site_settings[rhd_donate_cta_area_2_button_label]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_donate_cta_area_2_button_label'] ) ? $this->options['rhd_donate_cta_area_2_button_label'] : ''
		);

		printf(
			'<p><label for="rhd_donate_cta_area_2_button_link">Button Link</label><br />
			<input type="url" id="rhd_donate_cta_area_2_button_link" name="rhd_site_settings[rhd_donate_cta_area_2_button_link]" class="widefat" value="%s" /></p>',
			isset( $this->options['rhd_donate_cta_area_2_button_link'] ) ? $this->options['rhd_donate_cta_area_2_button_link'] : ''
		);
	}
}

if( is_admin() )
	$rhd_settings_page = new rhd_settings();
