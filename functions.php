<?php
/**
 * "Hannah"
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


/* ==========================================================================
   Initialization
   ========================================================================== */

// Constants and Globals
define( "RHD_THEME_DIR", get_template_directory_uri() );
define( "RHD_IMG_DIR", get_template_directory_uri() . '/img' );
define( "RHD_GOOGLE_FONTS", 'Open+Sans:400,400i,700,800|BenchNine' );

$updir = wp_upload_dir();
define( "RHD_UPLOAD_URL", $updir['baseurl'] );


// Disable Editor
define( 'DISALLOW_FILE_EDIT', true );

function remove_customize_page(){
	global $submenu;
	unset($submenu['themes.php'][6]); // remove customize link
}
add_action( 'admin_menu', 'remove_customize_page');


// Includes
include_once( 'inc/rhd-shortcodes.php' );
include_once( 'inc/rhd-metabar.php' );
include_once( 'inc/rhd-branding.php' );
include_once( 'inc/rhd-settings.php' );
include_once( 'inc/rhd-meta-boxes.php' );
include_once( 'inc/rhd-cpt-testimonial.php' );
include_once( 'inc/rhd-theme.php' );


// Globally disable WP toolbar
// add_filter( 'show_admin_bar', '__return_false' );


/* ==========================================================================
	Toggles
   ========================================================================== */

define( 'RHD_AJAX_PAGINATION', false );


/* ==========================================================================
   Scripts + Styles
   ========================================================================== */

/**
 * rhd_enqueue_styles function.
 *
 * @access public
 * @return void
 */
function rhd_enqueue_styles() {
	global $theme_opts;

	wp_register_style( 'rhd-main', RHD_THEME_DIR . '/css/main.css', array(), null, 'all' );
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=' . RHD_GOOGLE_FONTS );

	$normalize_deps = array();

	wp_register_style( 'normalize', RHD_THEME_DIR . '/css/normalize.css', $normalize_deps, null, 'all' );

	wp_enqueue_style( 'rhd-main' );
	wp_enqueue_style( 'normalize' );
	wp_enqueue_style( 'google-fonts' );
}
add_action( 'wp_enqueue_scripts', 'rhd_enqueue_styles' );


/**
 * rhd_enqueue_scripts function.
 *
 * @access public
 * @return void
 */
function rhd_enqueue_scripts() {
	wp_register_script( 'rhd-plugins', RHD_THEME_DIR . '/js/plugins.js', array( 'jquery' ), null, true );
	wp_register_script( 'rhd-ajax', RHD_THEME_DIR . '/js/ajax.js', array( 'jquery' ), null, true );
	wp_register_script( 'jquery-visible', RHD_THEME_DIR . '/js/vendor/df-visible/jquery.visible.min.js', array( 'jquery'), null, true );
	wp_register_script( 'rhd-metabar', RHD_THEME_DIR . '/js/metabar.js', array( 'jquery' ), null, true );
	wp_register_script( 'scrollax', RHD_THEME_DIR . '/js/vendor/Scrollax.js/scrollax.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'imagesloaded', RHD_THEME_DIR . '/js/vendor/imagesloaded/imagesloaded.pkgd.min.js', array( 'jquery' ), null, true );

	$main_deps = array(
		'rhd-plugins',
		'jquery',
		'jquery-effects-core',
		'scrollax',
		'imagesloaded'
	);
	wp_register_script( 'rhd-main', RHD_THEME_DIR . '/js/main.js', $main_deps, null, true );

	wp_enqueue_script( 'rhd-plugins' );
	wp_enqueue_script( 'rhd-metabar' );
	wp_enqueue_script( 'rhd-main' );

	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );

	// Localize data for client-side use
	global $wp_query;
	$data = array(
		'home_url' => home_url(),
		'theme_dir' => RHD_THEME_DIR,
		'img_dir' => RHD_IMG_DIR,
	);
	wp_localize_script( 'rhd-main', 'wp_data', $data );

	if ( RHD_AJAX_PAGINATION ) {
		wp_enqueue_script( 'rhd-ajax' );

		$data_ajax = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'query_vars' => json_encode( $wp_query->query )
		);
		wp_localize_script( 'rhd-ajax', 'wp_data', $data_ajax );
	}
}
add_action( 'wp_enqueue_scripts', 'rhd_enqueue_scripts' );


/**
 * rhd_add_editor_styles function.
 *
 * @access public
 * @return void
 */
function rhd_add_editor_styles() {
	//Google Fonts in admin editor
	$font_url = '//fonts.googleapis.com/css?family=' . RHD_GOOGLE_FONTS;
	$font_url = str_replace( ',', '%2C', $font_url );
	$font_url = str_replace( ':', '%3A', $font_url );
    add_editor_style( $font_url );


	add_editor_style( RHD_THEME_DIR . '/css/editor.css' );
}
add_action( 'after_setup_theme', 'rhd_add_editor_styles' );


/**
 * rhd_pageview_protection function.
 *
 * @access public
 * @return void
 */
function rhd_pageview_protection() {
	echo '<script language="javascript" type="text/javascript">if (window!= top) top.location.href = location.href;</script>';
}
add_action( 'wp_head', 'rhd_pageview_protection' );


/* ==========================================================================
   Theme Setup
   ========================================================================== */

/**
 * rhd_theme_setup function.
 *
 * @access public
 * @return void
 */
function rhd_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'infinite-scroll', array( 'container' => 'content', 'footer' => 'page' ) );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menu( 'primary', 'Main Site Navigation' );

	// Allow shortcodes in widgets
	add_filter( 'widget_text', 'do_shortcode' );

	// Enable themes auto-update
	add_filter( 'allow_minor_auto_core_updates', '__return_true' );

	// Content Width
	if ( ! isset( $content_width ) ) {
		$content_width = 620;
	}
}
add_action( 'after_setup_theme', 'rhd_theme_setup' );


/**
 * rhd_attachment_display_settings function.
 *
 * @access public
 * @return void
 */
function rhd_attachment_display_settings() {
	update_option( 'image_default_link_type', 'none' );
	update_option( 'image_default_size', 'large' );
}
add_action( 'after_setup_theme', 'rhd_attachment_display_settings' );


/**
 * rhd_image_sizes function.
 *
 * @access public
 * @return void
 */
function rhd_image_sizes() {
	add_image_size( 'square', 400, 400, true );
}
add_action( 'after_setup_theme', 'rhd_image_sizes' );


/**
 * rhd_add_image_sizes function.
 *
 * Adds images sizes to the media library.
 *
 * @access public
 * @param mixed $sizes
 * @return void
 */
function rhd_add_image_sizes( $sizes ) {
	$addsizes = array(
		"square" => __( "Square" )
	);
	$newsizes = array_merge( $sizes, $addsizes );

	return $newsizes;
}
add_filter( 'image_size_names_choose', 'rhd_add_image_sizes' );


/**
 * rhd_register_sidebars function.
 *
 * @access public
 * @return void
 */
function rhd_register_sidebars() {
	register_sidebar( array(
		'name'			=> __( 'Sidebar', 'rhd' ),
		'id'			=> 'sidebar',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));
}
add_action( 'widgets_init', 'rhd_register_sidebars' );


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

	$http_user_agent = ! empty( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : null;

	if ( preg_match( '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower( $http_user_agent ) ) ) {
	    ++$mobile_browser;
	}

	if ( ( strpos( strtolower( $_SERVER['HTTP_ACCEPT'] ),'application/vnd.wap.xhtml+xml' ) > 0 ) or ( ( isset( $_SERVER['HTTP_X_WAP_PROFILE'] ) or isset( $_SERVER['HTTP_PROFILE'] ) ) ) ) {
	    ++$mobile_browser;
	}

	$mobile_ua = strtolower( substr( $http_user_agent, 0, 4) );
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

	if ( in_array( $mobile_ua,$mobile_agents ) ) {
	    ++$mobile_browser;
	}

	if ( array_key_exists( 'ALL_HTTP', $_SERVER ) ) {
		if ( strpos( strtolower ($_SERVER['ALL_HTTP'] ),'OperaMini' ) > 0 ) {
		    ++$mobile_browser;
		}
	}

	if ( strpos( strtolower( $http_user_agent ),'windows') > 0 ) {
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


/**
 * rhd_gallery_atts function.
 *
 * @access public
 * @param mixed $out
 * @param mixed $pairs
 * @param mixed $atts
 * @return void
 */
function rhd_gallery_atts( $out, $pairs, $atts ) {
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
 * rhd_filter_media_comment_status function.
 *
 * @access public
 * @param mixed $open
 * @param mixed $post_id
 * @return void
 */
function rhd_filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'rhd_filter_media_comment_status', 10 , 2 );


/**
 * rhd_archive_pagination function.
 *
 * @access public
 * @param WP_Query $q (default: null)
 * @return void
 */
function rhd_archive_pagination( WP_Query $q = null ) {
	global $paged;

	if ( $q ) {
		$max_page = $q->max_num_pages;
	} else {
		$max_page = null;
	}

	$sep = ( get_previous_posts_link() != '' ) ? '<div class="pag-sep"></div>' : null;

	if ( ! is_front_page() ) {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	} else {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	}

	$next = $paged + 1;
	$prev = $paged - 1;

	echo '
		<nav class="pagination" data-current-page="' . $paged . '">
			<span class="pag-next pag-link" data-target-page="' . $next . '">' . get_next_posts_link( '&larr; Older', $max_page ) . '</span>';

		if ( $sep ) {
			echo '<div class="pag-sep"></div>';
		}

	echo '
			<span class="pag-prev pag-link" data-target-page="' . $prev . '">' . get_previous_posts_link( 'Newer &rarr;' ) . '</span>
		</nav>
		';
}


/**
 * rhd_single_pagination function.
 *
 * @access public
 * @return void
 */
function rhd_single_pagination() {
	$next = get_previous_post_link( '%link', '&lt; Older' );
	$prev = get_next_post_link( '%link', 'Newer &gt;' );
	$spacer = '<div class="pag-spacer"></div>';

	echo "<nav class='single-pagination'>\n";

	echo ( $next != '' ) ? '<span class="pag-next pag-link">' . $next . '</span>' : $spacer;

	echo  "<div class='pag-sep'></div>\n";

	echo ( $prev != '' ) ? '<span class="pag-prev pag-link">' . $prev . '</span>' : $spacer;

	echo "</nav>\n";
}


/**
 * rhd_load_more function.
 *
 * @access public
 * @param WP_Query $q (default: null)
 * @return void
 */
function rhd_load_more( WP_Query $q = null ) {
	global $paged;

	if ( $q ) {
		$max_page = $q->max_num_pages;
	} else {
		$max_page = null;
	}

	$sep = ( get_previous_posts_link() != '' ) ? '<div class="pag-sep"></div>' : null;

	if ( ! is_front_page() ) {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	} else {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	}

	$next = $paged + 1;

	echo '
		<nav class="pagination" data-current-page="' . $paged . '">
			<span class="pag-load-more" data-target-page="' . $next . '">' . get_next_posts_link( 'Show More', $max_page ) . '</span>
		</nav>
		';
}


/**
 * rhd_ajax_pagination function.
 *
 * @access public
 * @return void
 */
function rhd_ajax_pagination() {
	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	$query_vars['paged'] = $_POST['page'];
	$posts = new WP_Query( $query_vars );
	$GLOBALS['wp_query'] = $posts;

	if( $posts->have_posts() ) {
		while ( $posts->have_posts() ) {
			$posts->the_post();
			get_template_part( 'template-parts/content' );
		}
	}
	wp_reset_postdata();

	if ( $_POST['load_more'] )
		rhd_load_more( $posts );
	else
		rhd_archive_pagination( $posts );

	die();
}
add_action( 'wp_ajax_nopriv_ajax_pagination', 'rhd_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'rhd_ajax_pagination' );


/**
 * Function: rhd_title_check_hidden
 *
 * Hides widget titles contained within parentheses '()'
 *
 * @param string $title
 **/

function rhd_title_check_hidden( $title ) {
	if ( stripos($title, '(') !== false && stripos($title, ')') !== false ) {
		$first = substr($title, 0, 1);
		$last = substr($title, -1, 1);

		if ($first == '(' && $last == ')') $title = '';
		else $title = preg_replace('/\((.*?)\)/', '', $title);
	}
	return $title;
}
add_filter( 'widget_title', 'rhd_title_check_hidden' );


/**
 * rhd_navbar_search_form function.
 *
 * @access public
 * @param string $placeholder (default: "Search")
 * @return void
 */
function rhd_navbar_search_form( $placeholder = "Search" )
{
	echo '
		<div class="navbar-search">
			<form method="get" class="search-form" action="' . esc_url( home_url('/') ) . '">
				<div>
					<input type="text" value="" class="search-field" name="s" placeholder="' . $placeholder . '" />
					<input type="submit" class="search-submit" value="" />
				</div>
				<a class="close-search" href="#">X</a>
			</form>
		</div>
		';
}


/**
 * rhd_is_last_post function.
 *
 * @access public
 * @return void
 */
function rhd_is_last_post() {
	global $wp_query;

	if ( $wp_query->current_post + 1 < $wp_query->post_count )
		return false;
	else return true;
}


/**
 * rhd_paged function.
 *
 * @access public
 * @return void
 *
 * Handles pagination ('paged') setup for secondary loops.
 */
function rhd_paged() {
	if ( get_query_var( 'paged' ) )
		$paged = get_query_var( 'paged' );
	else {
		if( get_query_var( 'page' ) )
		    $my_page = get_query_var( 'page' );
		else
			$my_page = 1;

		set_query_var( 'paged', $my_page );
		$paged = $my_page;
	}

	return $paged;
}
