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

function rhd_init()
{
	// Constants
	define( "RHD_THEME_DIR", get_template_directory_uri() );
	define( "RHD_IMG_DIR", get_template_directory_uri() . '/img' );
}
add_action( 'after_setup_theme', 'rhd_init' );

/* Disable Editor */
define( 'DISALLOW_FILE_EDIT', true );


/* ==========================================================================
   Scripts + Styles
   ========================================================================== */

function rhd_enqueue_styles()
{
	global $theme_opts;

	wp_register_style( 'rhd-main', RHD_THEME_DIR . '/css/main.css', array(), '1', 'all' );
	wp_register_style( 'rhd-enhanced', RHD_THEME_DIR . '/css/enhanced.css', array(), '1', 'all' );
	wp_register_style( 'slidebars', RHD_THEME_DIR . '/js/vendor/Slidebars/dist/slidebars.min.css', array(), '0.10.3', 'screen' );
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Cinzel:700|Lato:400,400italic,700' );

	$normalize_deps = array(
		'slidebars',
	);

	if ( !rhd_is_mobile() ) {
		wp_enqueue_style( 'rhd-enhanced' );
	}

	wp_register_style( 'normalize', RHD_THEME_DIR . '/css/normalize.css', $normalize_deps, null, 'all' );

	wp_enqueue_style( 'rhd-main' );
	wp_enqueue_style( 'normalize' );
	wp_enqueue_style( 'google-fonts' );
}
add_action( 'wp_enqueue_scripts', 'rhd_enqueue_styles' );

function rhd_enqueue_scripts()
{
	wp_register_script( 'modernizr', RHD_THEME_DIR . '/js/vendor/modernizr/modernizr-custom.js', null, '2.8.3', false );
	wp_register_script( 'rhd-plugins', RHD_THEME_DIR . '/js/plugins.js', array( 'jquery' ), null, true );
	wp_register_script( 'slidebars', RHD_THEME_DIR . '/js/vendor/Slidebars/dist/slidebars.min.js', array( 'jquery' ), '0.10.3', true );

	$main_deps = array(
		'rhd-plugins',
		'jquery',
		'modernizr',
		'slidebars',
	);
	wp_register_script( 'rhd-main', RHD_THEME_DIR . '/js/main.js', $main_deps, null, false );

	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'rhd-plugins' );
	wp_enqueue_script( 'rhd-main' );

	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );


	// Localize data for client-side use
	global $wp_query;
	$data = array(
		'home_url' => home_url(),
		'theme_dir' => RHD_THEME_DIR,
		'img_dir' => RHD_IMG_DIR,
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'query_vars' => json_encode( $wp_query->query ),
	);
	wp_localize_script( 'rhd-plugins', 'wp_data', $data);

}
add_action('wp_enqueue_scripts', 'rhd_enqueue_scripts');


/**
 * register_jquery function.
 *
 * @access public
 * @return void
 */
function rhd_register_jquery()
{
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', RHD_THEME_DIR . '/js/vendor/jquery/dist/jquery.min.js' );
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueuescripts', 'rhd_register_jquery' );

function rhd_add_editor_styles()
{
	//Google Fonts in admin editor
	$font_url = '//fonts.googleapis.com/css?family=Cinzel:700|Lato:400,400italic,700';
	$font_url = str_replace( ',', '%2C', $font_url );
	$font_url = str_replace( ':', '%3A', $font_url );
    add_editor_style( $font_url );


	add_editor_style( RHD_THEME_DIR . '/css/editor.css' );
}
add_action( 'after_setup_theme', 'rhd_add_editor_styles' );


/* ==========================================================================
   Sidebars + Menus
   ========================================================================== */

// Sidebars
function rhd_register_sidebars()
{

}
add_action( 'widgets_init', 'rhd_register_sidebars' );

// Menus
register_nav_menu( 'primary', 'Main Site Navigation' );
register_nav_menu( 'slidebar', 'Slidebar Site Navigation' );

/**
 * RHD_Walker_Nav class.
 *
 * Adds newlines after each </li> closing tag.
 *
 * @extends Walker_Nav_Menu
 */
class RHD_Walker_Nav extends Walker_Nav_Menu {
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

// Includes and Requires
//include_once( 'includes/rhd-admin-panel.php' );


/* ==========================================================================
   Registrations, Theme Support, Thumbnails
   ========================================================================== */

// Theme Support
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'infinite-scroll', array( 'container' => 'content', 'footer' => 'page' ) );
}


// Enable themes auto-update
add_filter( 'allow_minor_auto_core_updates', '__return_true' );


// Content Width
if ( ! isset( $content_width ) ) {
	$content_width = 620;

}


/**
 * rhd_attachment_display_settings function.
 *
 * @access public
 * @return void
 */
function rhd_attachment_display_settings()
{
	//update_option( 'image_default_align', 'left' );
	update_option( 'image_default_link_type', 'none' );
	update_option( 'image_default_size', 'large' );
}
add_action( 'after_setup_theme', 'rhd_attachment_display_settings' );


// Adds RSS feed links to for posts and comments.
add_theme_support( 'automatic-feed-links' );

function rhd_image_sizes()
{
	add_image_size( 'square', 300, 300, true );
}
add_action( 'after_setup_theme', 'rhd_image_sizes' );

// Allow shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );


// Hide Admin Bar
show_admin_bar( false );


/* ==========================================================================
   Roundhouse Admin Branding
   ========================================================================== */

// External login link
function rhd_branding_login()
{
	return "//roundhouse-designs.com/";
}
add_filter('login_headerurl', 'rhd_branding_login');


// Site Title as "login message" (underneath RHD logo)
function rhd_login_message() {
	echo '<h1 class="rhd-login-site-title">' . get_bloginfo('name') . "</h1>\n";
}
add_action( 'login_message', 'rhd_login_message' );


// Roundhouse Branding CSS
function rhd_login()
{
	wp_enqueue_style( 'rhd_login', get_stylesheet_directory_uri() . '/rhd/rhd-login.css' );
}
add_action('login_head', 'rhd_login');


function rhd_admin()
{
	wp_enqueue_style( 'rhd_admin', get_stylesheet_directory_uri() . '/rhd/rhd-admin.css' );
}
add_action('admin_head', 'rhd_admin');


// Custom WordPress Footer
function rhd_footer_admin ()
{
	return '&copy; ' . date("Y") . ' - Roundhouse <img class="rhd-admin-colophon-logo" src="//assets.roundhouse-designs.com/images/rhd-black-house.png" alt="Roundhouse Designs"> Designs';
}
add_filter('admin_footer_text', 'rhd_footer_admin');


// Remove 'Editor' panel
function rhd_remove_editor_menu()
{
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
function rhd_is_mobile()
{
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

	if ( array_key_exists( 'ALL_HTTP', $_SERVER ) ) {
		if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
		    $mobile_browser++;
		}
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
function get_the_slug()
{
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

function rhd_strip_thumbnail_dimensions( $html )
{
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
function rhd_add_async( $url )
{
	if ( strpos( $url, '#async') === false )
		return $url;
	elseif ( is_admin() )
		return str_replace( '#async', '', $url );
	else
		return str_replace( '#async', '', $url ) . "' async";
}
add_filter( 'clean_url', 'rhd_add_async', 11, 1 );


/**
 * rhd_gallery_atts function.
 *
 * @access public
 * @param mixed $out
 * @param mixed $pairs
 * @param mixed $atts
 * @return void
 */
function rhd_gallery_atts( $out, $pairs, $atts )
{
	$atts = shortcode_atts(
		array(
			'link' => 'file'
		), $atts );

	$out['link'] = $atts['link'];

/*
	Other example defaults:
	$out['columns'] = $atts['columns'];
	$out['size'] = $atts['size'];
*/

	return $out;
}
add_filter( 'shortcode_atts_gallery', 'rhd_gallery_atts', 10, 3 );


/**
 * rhd_enhance_excerpts function.
 *
 * @access public
 * @param mixed $text
 * @return void
 */
function rhd_enhance_excerpts( $text )
{
	global $post;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace('\]\]\>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<a>');
		$excerpt_length = 80;
		$words = explode(' ', $text, $excerpt_length + 1);
		if ( count( $words ) > $excerpt_length) {
			array_pop( $words );
			array_push( $words, '... <a class="readmore" href="'. get_permalink($post->ID) . '">Continue reading &rarr;</a>' );
			$text = implode(' ', $words);
        }
	}
	return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'rhd_enhance_excerpts');


/**
 * rhd_archive_pagination function.
 *
 * @access public
 * @param WP_Query $q (default: null)
 * @return void
 */
function rhd_archive_pagination( WP_Query $q = null )
{
	$max_page = ( $q ) ? $q->max_num_pages : null;

	$sep = ( get_previous_posts_link() != '' ) ? '<div class="pag-sep"></div>' : null;

	echo '<nav class="pagination">';

	echo '<span class="pag-next">' . get_next_posts_link( '&larr; Older', $max_page ) . '</span>';

	if ( $sep ) {
		echo '<div class="pag-sep"></div>';
	}

	echo '<span class="pag-prev">' . get_previous_posts_link( 'Newer &rarr;' ) . '</span>';
	echo '</nav>';
}


/**
 * rhd_lovely_single_pagination function.
 *
 * @access public
 * @return void
 */
function rhd_single_pagination()
{
	$next = get_previous_post_link( '%link', '&lt; Older' );
	$prev = get_next_post_link( '%link', 'Newer &gt;' );
	$spacer = '<div class="pag-spacer"></div>';

	echo "<nav class='single-pagination'>\n";

	echo ( $next != '' ) ? $next : $spacer;

	echo  "<div class='pag-sep'></div>\n";

	echo ( $prev != '' ) ? $prev : $spacer;

	echo "</nav>\n";
}


/**
 * rhd_ajax_pagination function.
 *
 * @access public
 * @return void
 */
function rhd_ajax_pagination()
{
	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	$query_vars['paged'] = $_POST['page'];
	$posts = new WP_Query( $query_vars );
	$GLOBALS['wp_query'] = $posts;

	add_filter( 'editor_max_image_size', 'rhd_image_size_override' );

	if( ! $posts->have_posts() ) {
		get_template_part( 'content', 'none' );
	} else {
		while ( $posts->have_posts() ) {
			$posts->the_post();
			get_template_part( 'content' );
		}
	}

	remove_filter( 'editor_max_image_size', 'rhd_image_size_override' );

	the_posts_pagination( array(
		'mid_size' => 1,
		'prev_text' => __( 'Previous', 'rhd' ),
		'next_text' => __( 'Next', 'rhd' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'rhd' ) . ' </span>',
	) );

	die();
}
add_action( 'wp_ajax_nopriv_ajax_pagination', 'rhd_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'rhd_ajax_pagination' );


/**
 * rhd_image_size_override function.
 *
 * @access public
 * @return void
 */
function rhd_image_size_override()
{
	return array( 825, 510 );
}


/**
 * Function: rhd_title_check_hidden
 *
 * Hides widget titles contained within parentheses '()'
 *
 * @param string $title
 **/

function rhd_title_check_hidden( $title )
{
	if ( stripos($title, '(') !== false && stripos($title, ')') !== false ) {
		$first = substr($title, 0, 1);
		$last = substr($title, -1, 1);

		if ($first == '(' && $last == ')') $title = '';
		else $title = preg_replace('/\((.*?)\)/', '', $title);
	}
	return $title;
}
add_filter('widget_title', 'rhd_title_check_hidden');


/**
 * rhd_body_class function.
 *
 * @access public
 * @return void
 */
function rhd_body_class( $body_classes )
{
	// Basic front page & device detection
	$body_classes[] = ( is_front_page() ) ? 'blog' : '';
	$body_classes[] = ( rhd_is_mobile() ) ?  'mobile' : '';
	$body_classes[] = ( wp_is_mobile() && !rhd_is_mobile() ) ? 'tablet' : '';
	$body_classes[] = ( !wp_is_mobile() && !rhd_is_mobile() ) ? 'desktop' : '';

/*
	session_start();
	if ( is_home() || is_single() || is_archive() || is_search() ) {
		$body_classes[] = 'blog-area';

		$_SESSION['blog_area'] = true;
	} else {
		$_SESSION['blog_area'] = false;
	}
*/

	return $body_classes;
}
add_filter( 'body_class', 'rhd_body_class' );


/* ==========================================================================
	Theme Functions and Customizations
   ========================================================================== */

/**
 * rhd_image_sizes function.
 *
 * @access public
 * @param mixed $sizes
 * @return void
 */
function rhd_image_sizes_admin( $sizes )
{
	$addsizes = array(
		"square" => __( "Square" )
	);
	$newsizes = array_merge( $sizes, $addsizes );
	return $newsizes;
}
add_filter( 'image_size_names_choose', 'rhd_image_sizes_admin' );


/**
 * rhd_title_style function.
 *
 * @access public
 * @return void
 */
function rhd_title_style()
{
	global $post;

	// Check if a child of the "photo" page or is a 404
	if ( $post->post_parent == 24 || is_404() ) {
		$title_style = "short";
	} else {
		// Title vertical position
		if ( is_home() || is_page( 'video') || is_page( 'photos' ) || is_page( 'voice-studio' ) || is_page( 'concerts' ) )
			$v = 'top';
		else
			$v = 'bottom';

		// Title horizontal position
		if ( is_page( 'about' ) || is_page( 'press' ) || is_page( 'concerts' ) || is_page( 'contact' ) )
			$h = 'right';
		else
			$h = 'left';

		// Title color
		if ( is_home() || is_page( 'about') || is_page( 'reviews' ) || is_page( 'contact' ) || is_page( 'concerts' ) || is_page( 'voice-studio' )|| is_page( 'press' ) )
			$c = 'white';
		else
			$c = 'black';

		$title_style = "$v $h $c";
	}

	return $title_style;
}



function your_custom_menu_item ( $items, $args )
{
	if ( $args->theme_location == 'primary' ) {
		$items .= '<li class="menu-item menu-item-rhd-social">' . do_shortcode( '[rhd-social-icons facebook="https://www.facebook.com/catherine.walker.965" twitter="@ccatwalker" instagram="@ccatwalker1" color1="#fff" color2="#E597FF"]' ) . '</li>';
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );