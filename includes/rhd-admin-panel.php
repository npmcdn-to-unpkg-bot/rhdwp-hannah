<?php
/**
 * Theme Options Admin Panel
 *
 * Theme settings page
 *
 * @package WordPress
 * @subpackage rhd
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
		add_menu_page(
			'RHD General Settings',
			'Theme Settings',
			'manage_options',
			'rhd_settings',
			array( $this, 'create_admin_page' ),
			'dashicons-admin-generic',
			8
		);
	}

	/**
	* Options page callback
	*/
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'rhd_theme_settings' );
	?>
	<div class="wrap">
		<h2>RHD Theme Settings</h2>
		<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'rhd_settings_group' );
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
			'rhd_settings_group', // Option group
			'rhd_theme_settings', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'rhd_js_section', // ID
			'Theme JS', // Title
			array( $this, 'print_section_info' ), // Callback
			'rhd-settings-admin' // Page
		);

		add_settings_field(
			'rhd_include_slidebars', // ID
			'Slidebars', // Title
			array( $this, 'rhd_include_slidebars_cb' ), // Callback
			'rhd-settings-admin', // Page
			'rhd_js_section' // Section
		);

		add_settings_field(
			'rhd_include_packery', // ID
			'Packery', // Title
			array( $this, 'rhd_include_packery_cb' ), // Callback
			'rhd-settings-admin', // Page
			'rhd_js_section' // Section
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

		$new_input['rhd_include_slidebars'] = $input['rhd_include_slidebars'];
		$new_input['rhd_include_packery'] = $input['rhd_include_packery'];

		return $new_input;
	}

	/**
	* Print the Section text
	*/
	public function print_section_info()
	{
		print 'Include the following JS libraries:';
	}

	/**
	* Input callbacks
	*/
	public function rhd_include_slidebars_cb()
	{
		echo '<input type="checkbox" id="rhd_include_slidebars" name="rhd_theme_settings[rhd_include_slidebars]" value="1" ' . checked( 1, $this->options['rhd_include_slidebars'], false ) . ' />';
	}

	public function rhd_include_packery_cb()
	{
		echo '<input type="checkbox" id="rhd_include_packery" name="rhd_theme_settings[rhd_include_packery]" value="1" ' . checked( 1, $this->options['rhd_include_packery'], false ) . ' />';
	}
}

if( is_admin() )
	$rhd_settings_page = new RHD_Settings();