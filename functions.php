<?php
/**
 * RHD Base
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhd
 **/


/* ==========================================================================
   Initialization
   ========================================================================== */

function rhd_init() {
	// Constants
	define( "RHD_THEME_DIR", get_template_directory_uri() );
	define( "RHD_IMG_DIR", get_template_directory_uri() . '/img' );
}
add_action( 'after_setup_theme', 'rhd_init' );

/* Disable Editor */
define( 'DISALLOW_FILE_EDIT', true );

/* Google Fonts */
$font_family = 'Lato:400,400italic,700|Rock+Salt';


/* ==========================================================================
   Scripts + Styles
   ========================================================================== */

function rhd_enqueue_styles(){
	// wp_enqueue_style('theme', get_stylesheet_uri(), array('dashicons'), '1', 'all');
	wp_enqueue_style( 'rhd-main', RHD_THEME_DIR . '/css/main.css', array(), '1', 'all' );
	wp_enqueue_style( 'normalize', RHD_THEME_DIR . '/css/normalize.css', array( 'slidebars-js-css' ), null, 'all' );
	wp_enqueue_style( 'slidebars-js-css', RHD_THEME_DIR . '/js/vendor/Slidebars/distribution/0.10.2/slidebars.min.css', '', '0.10.0' );

	// Web Fonts
	wp_enqueue_style( 'google-fonts', "//fonts.googleapis.com/css?family={$font_family}" );

	if ( !rhd_is_mobile() ) {
		wp_enqueue_style( 'rhd-enhanced', RHD_THEME_DIR . '/css/enhanced.css', array(), '1', 'all' );
	}
}
add_action( 'wp_enqueue_scripts', 'rhd_enqueue_styles' );

function rhd_enqueue_scripts() {
	wp_enqueue_script( 'rhd-plugins', RHD_THEME_DIR . '/js/plugins.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rhd-main', RHD_THEME_DIR . '/js/main.js', array( 'rhd-plugins', 'jquery' ), '', true );
	wp_enqueue_script( 'modernizr', RHD_THEME_DIR . '/js/vendor/modernizr/modernizr-custom.js', '', '2.8.3', true );
	wp_enqueue_script( 'slidebars-js', RHD_THEME_DIR . '/js/vendor/Slidebars/distribution/0.10.2/slidebars.min.js', '', '0.10.2', true );

	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );
}
add_action('wp_enqueue_scripts', 'rhd_enqueue_scripts');

function rhd_setup_admin( $hook ) {
	if ( $hook == 'profile.php' || $hook == 'user-edit.php' ) {
		wp_enqueue_script('rhd-admin-js', RHD_THEME_DIR . '/js/admin.js', array('jquery'));
		wp_enqueue_media();
	}
	else {
		return;
	}
}
add_action( 'admin_enqueue_scripts', 'rhd_setup_admin' );

function rhd_add_editor_styles() {
	//Google Fonts in admin editor
	$font_url = "//fonts.googleapis.com/css?family={$font_family}";
	$font_url = str_replace( ',', '%2C', $font_url );
	$font_url = str_replace( ':', '%3A', $font_url );
    add_editor_style( $font_url );
	

	add_editor_style( RHD_THEME_DIR . '/css/editor.css' );
}
add_action( 'after_setup_theme', 'rhd_add_editor_styles' );


/**
 * Function: rhd_favicons
 *
 * Outputs default favicon linkage, generated by http://realfavicongenerator.net/
 **/
function rhd_favicons() {
	echo '
		<link rel="shortcut icon" href="' . RHD_THEME_DIR . '/favicon/favicon.ico">
		<link rel="apple-touch-icon" sizes="57x57" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="114x114" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="72x72" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="60x60" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="120x120" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="76x76" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="152x152" href="' . RHD_THEME_DIR . '/favicon/apple-touch-icon-152x152.png">
		<link rel="icon" type="image/png" href="' . RHD_THEME_DIR . '/favicon/favicon-196x196.png" sizes="196x196">
		<link rel="icon" type="image/png" href="' . RHD_THEME_DIR . '/favicon/favicon-160x160.png" sizes="160x160">
		<link rel="icon" type="image/png" href="' . RHD_THEME_DIR . '/favicon/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="' . RHD_THEME_DIR . '/favicon/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="' . RHD_THEME_DIR . '/favicon/favicon-32x32.png" sizes="32x32">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="msapplication-TileImage" content="' . RHD_THEME_DIR . '/favicon/mstile-144x144.png">
		<meta name="msapplication-config" content="' . RHD_THEME_DIR . '/favicon/browserconfig.xml">
	';
}
add_action( 'wp_head', 'rhd_favicons' );


/* ==========================================================================
   Sidebars + Menus
   ========================================================================== */

// Sidebars
function rhd_register_sidebars() {
	register_sidebar(array(
		'name'			=> __( 'Sidebar', 'rhd' ),
		'id'			=> 'sidebar',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Nav Widget Area', 'rhd' ),
		'id'			=> 'nav',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget nav-widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Footer Widget Area', 'rhd' ),
		'id'			=> 'footer',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>'
	));
}
add_action( 'widgets_init', 'rhd_register_sidebars' );

// Menus
register_nav_menu( 'primary', 'Main Site Navigation' );


/* ==========================================================================
   Registrations, Theme Support, Thumbnails
   ========================================================================== */

// Theme Support
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
}

// Enable themes auto-update
add_filter( 'auto_update_theme', '__return_true' );

// Content Width
if ( ! isset( $content_width ) ) {
	$content_width = 620;
}


/* ==========================================================================
   Roundhouse Admin Branding
   ========================================================================== */

// External login link
function rhd_branding_login(){
	return "http://roundhouse-designs.com/"; // your URL here
}
add_filter('login_headerurl', 'rhd_branding_login');

// Site Title as "login message" (underneath RHD logo)
function rhd_login_message() { ?>
	<h1 class="rhd-login-site-title"><?php bloginfo('name'); ?></h1>
<?php }
add_action( 'login_message', 'rhd_login_message' );

// Roundhouse Branding CSS
function rhd_login() {
	wp_enqueue_style( 'rhd_login', get_stylesheet_directory_uri() . '/rhd/rhd-login.css' );
}
add_action('login_head', 'rhd_login');
function rhd_admin() {
	wp_enqueue_style( 'rhd_admin', get_stylesheet_directory_uri() . '/rhd/rhd-admin.css' );
}
add_action('admin_head', 'rhd_admin');

// Custom WordPress Footer
function rhd_footer_admin () {
	echo '&copy; ' . date("Y") . ' - Roundhouse <img class="rhd-admin-colophon-logo" src="http://assets.roundhouse-designs.com/images/rhd-black-house.png" alt="Roundhouse Designs"> Designs';
}
add_filter('admin_footer_text', 'rhd_footer_admin');

// Remove 'Editor' panel
function rhd_remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}
add_action('_admin_menu', 'rhd_remove_editor_menu', 1);


/* ==========================================================================
   Helpers
   ========================================================================== */

/**
 * rhd_is_mobile function.
 *
 * @access public
 * @return void
 */
function rhd_is_mobile() {
	$mobile_browser = 0;

	if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
	    $mobile_browser++;
	}

	if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
	    $mobile_browser++;
	}

	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
	$mobile_agents = array(
	    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
	    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
	    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
	    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
	    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
	    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
	    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
	    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
	    'wapr','webc','winw','winw','xda ','xda-');

	if (in_array($mobile_ua,$mobile_agents)) {
	    $mobile_browser++;
	}

	if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
	    $mobile_browser++;
	}

	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
	    $mobile_browser = 0;
	}

	if ( $mobile_browser > 0 ) {
		$mobile_browser = TRUE;
	} else {
		$mobile_browser = FALSE;
	}

	return $mobile_browser;
}


/**
 * get_the_slug function.
 *
 * @access public
 * @return void
 */
function get_the_slug() {
	$post_data = get_post( $post->ID, ARRAY_A );
	$slug = $post_data['post_name'];
	return $slug;
}


/**
 * Function: rhd_strip_thumbnail_dimensions
 *
 * Strip WP inline image dimensions
 *
 * @param $html
 **/
add_filter( 'post_thumbnail_html', 'rhd_strip_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'rhd_strip_thumbnail_dimensions', 10 );

function rhd_strip_thumbnail_dimensions($html) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}


/**
 * rhd_add_async function.
 *
 * @access public
 * @param mixed $url
 * @return void
 */
function rhd_add_async( $url ) {
	if ( strpos( $url, '#async') === false )
		return $url;
	elseif ( is_admin() )
		return str_replace( '#async', '', $url );
	else
		return str_replace( '#async', '', $url ) . "' async";
}
add_filter( 'clean_url', 'rhd_add_async', 11, 1 );
