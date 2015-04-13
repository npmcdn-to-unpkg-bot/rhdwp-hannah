<?php
/**
 * Theme Options Admin Panel
 *
 * Sample admin settings page
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
		<h2>RHD Sample Settings</h2>           
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
			'rhd_sample_section', // ID
			'Sample Settings Section', // Title
			array( $this, 'print_section_info' ), // Callback
			'rhd-settings-admin' // Page
		);  
		
		add_settings_field(
			'rhd_sample_textfield', // ID
			'Sample Text Field: ', // Title 
			array( $this, 'sample_textfield_cb' ), // Callback
			'rhd-settings-admin', // Page
			'rhd_sample_section' // Section
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
		
		if( isset( $input['rhd_sample_textfield'] ) )
			$new_input['rhd_sample_textfield'] = sanitize_text_field( $input['rhd_sample_textfield'] );
		
		return $new_input;
	}
	
	/** 
	* Print the Section text
	*/
	public function print_section_info()
	{
		print 'Enter something here:';
	}
	
	/** 
	* Input callbacks
	*/
	public function sample_textfield_cb( $args )
	{
		printf(
			'<input type="text" id="rhd_sample_textfield" name="rhd_theme_settings[rhd_sample_textfield]" value="%s" />',
			isset( $this->options['rhd_sample_textfield'] ) ? esc_attr( $this->options['rhd_sample_textfield']) : ''
		);
	}
}
	
if( is_admin() )
	$rhd_settings_page = new RHD_Settings();