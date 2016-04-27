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
// define( 'DISALLOW_FILE_EDIT', true );


/* ==========================================================================
   Scripts + Styles
   ========================================================================== */

function rhd_enqueue_styles()
{
	global $theme_opts;

	wp_register_style( 'rhd-main', RHD_THEME_DIR . '/css/main.css', array(), '1', 'all' );
	wp_register_style( 'rhd-enhanced', RHD_THEME_DIR . '/css/enhanced.css', array(), '1', 'all' );
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Oswald:300|Open+Sans:400,700,400italic' );

	$normalize_deps = array();

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

	$main_deps = array(
		'rhd-plugins',
		'jquery',
		//'modernizr',
	);
	wp_register_script( 'rhd-main', RHD_THEME_DIR . '/js/main.js', $main_deps, null, false );

	// wp_enqueue_script( 'modernizr' );

	wp_enqueue_script( 'rhd-plugins' );
	wp_enqueue_script( 'rhd-main' );

	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );


/*
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
*/

}
add_action('wp_enqueue_scripts', 'rhd_enqueue_scripts');

function rhd_add_editor_styles()
{
	//Google Fonts in admin editor
	$font_url = '//fonts.googleapis.com/css?family=Oswald:300|Open+Sans:400,700,400italic';
/*
	$font_url = str_replace( ',', '%2C', $font_url );
	$font_url = str_replace( ':', '%3A', $font_url );
*/
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
	register_sidebar(array(
		'name'			=> __( 'Sidebar', 'rhd' ),
		'id'			=> 'sidebar',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Footer Widget Area (Left)', 'rhd' ),
		'id'			=> 'footer-widget-area-left',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Footer Widget Area (Right)', 'rhd' ),
		'id'			=> 'footer-widget-area-right',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>'
	));
}
add_action( 'widgets_init', 'rhd_register_sidebars' );


// Menus
register_nav_menu( 'primary', 'Main Site Navigation' );

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
add_theme_support( 'post-formats', array( 'link' ) );

function rhd_image_sizes()
{
	add_image_size( 'archive', 400, 533, true );
}
add_action( 'after_setup_theme', 'rhd_image_sizes' );


// Allow shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );


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
// add_action('_admin_menu', 'rhd_remove_editor_menu', 1);


// Globally disable WP toolbar
// add_filter( 'show_admin_bar', '__return_false' );


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
/*
add_filter( 'post_thumbnail_html', 'rhd_strip_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'rhd_strip_thumbnail_dimensions', 10 );
*/

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
 * rhd_modify_content_more_link function.
 *
 * @access public
 * @return void
 */
function rhd_modify_more_link( $more ) {
	return '<div class="ghost-button ghost-more"><a class="more-link" href="' . get_permalink() . '">Keep Reading &rarr;</a></div>';
}
add_filter( 'the_content_more_link', 'rhd_modify_more_link' );
add_filter( 'excerpt_more', 'rhd_modify_more_link' );


/**
 * rhd_archive_pagination function.
 *
 * @access public
 * @return void
 */
/*
function rhd_archive_pagination()
{
	$sep = ( get_previous_posts_link() != '' ) ? '<div class="pag-sep"></div>' : null;

	echo '<div class="pagination">';

	echo '<span class="pag-next">';
	next_posts_link( '&larr; Older', null );
	echo '</span>';

	if ( $sep ) {
		echo '<div class="pag-sep"></div>';
	}

	echo '<span class="pag-prev">';
	previous_posts_link( 'Newer &rarr;', null );
	echo '</span>';

	echo '</div>';
}
*/


/**
 * rhd_single_pagination function.
 *
 * @access public
 * @return void
 */
function rhd_single_pagination()
{
	$next = get_previous_post_link( '%link', '&laquo; Older' );
	$prev = get_next_post_link( '%link', 'Newer &raquo;' );
	$spacer = '<div class="pag-spacer"></div>';

	echo "<div class='single-pagination'>\n";

	echo ( $next != '' ) ? $next : $spacer;

	echo  "<div class='pag-sep'></div>\n";

	echo ( $prev != '' ) ? $prev : $spacer;

	echo "</div>\n";
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
	$body_classes[] = ( is_front_page() ) ? 'front-page' : '';
	$body_classes[] = ( rhd_is_mobile() ) ?  'mobile' : '';
	$body_classes[] = ( wp_is_mobile() && !rhd_is_mobile() ) ? 'tablet' : '';
	$body_classes[] = ( !wp_is_mobile() && !rhd_is_mobile() ) ? 'desktop' : '';

	session_start();
	if ( is_home() || is_single() || is_archive() || is_search() ) {
		$body_classes[] = 'blog-area';

		$_SESSION['blog_area'] = true;
	} else {
		$_SESSION['blog_area'] = false;
	}

	return $body_classes;
}
add_filter( 'body_class', 'rhd_body_class' );


/**
 * rhd_svg_logo_main function.
 *
 * @access public
 * @return void
 */
function rhd_svg_logo() {
	echo '
			<svg id="PLACEHOLDER">
				<a href="hide-on-fallback">
					<!-- SVG CODE HERE -->
				</a>
				<image src="' . RHD_IMG_DIR . '/logo-large.png" alt="' . get_bloginfo( 'name' ) . '" xlink:href="">
			</svg>
		';
}

/* ==========================================================================
	Theme Functions and Customizations
   ========================================================================== */

/**
 * rhd_entry_meta_box function.
 *
 * @access public
 * @return void
 */
function rhd_entry_meta_box() {
	echo '
		<div class="entry-meta-content">
			<p>
				Filed Under: ' . get_the_category_list( ', ' ) . '<br />';

				if ( has_tag() )
					the_tags( 'Tagged as: ' , ', ' );
					echo '<br />';

				comments_popup_link( 'No Comments &raquo;', '1 Comment &raquo;', '% Comments &raquo;', 'comments-popup-link', 'Comments are disabled.' );
	echo '
			</p>
		</div>';
}


/**
 * rhd_infinite_scroll_init function.
 *
 * @access public
 * @return void
 */
function rhd_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'post-grid',
		'render' => 'rhd_infinite_scroll_render',
		'footer' => false,
		'footer_widgets' => true,
		'posts_per_page' => 15,
	) );
}
add_action( 'init', 'rhd_infinite_scroll_init' );


/**
 * rhd_infinity_scroll_render function.
 *
 * @access public
 * @return void
 */
function rhd_infinite_scroll_render() {
	$paged = get_query_var( 'paged' );
	$queried = get_queried_object();

/*
	if ( $paged == $queried->max_num_pages )
		$paged = null;
*/

	error_log( $queried->max_num_pages );

	$args = array(
		'posts_per_page' => 15,
		'paged' => $paged + 1
	);

	if ( $queried->taxonomy == 'category' ) {
		$args['cat'] = $queried->cat_ID;
	} else {
		error_log( 'RHD THEME ERROR: Infinite Scroll customization -- not a category. See functions.php' );
	}

	$q = new WP_Query( $args );

	while ( $q->have_posts() ) {
		$q->the_post();
		get_template_part( 'content', 'archive' );
	}
	wp_reset_postdata();
}


/**
 * rhd_infinite_scroll_more function.
 *
 * @access public
 * @return void
 */
function rhd_infinite_scroll_more() {
	if ( is_home() || is_archive() ) :
	echo '
		<script type="text/javascript">
		//<![CDATA[
		infiniteScroll.settings.text = "Load More";
		//]]>
		</script>
		';
	endif;
}
add_action( 'wp_footer', 'rhd_infinite_scroll_more', 3 );


/**
 * rhd_byline function.
 *
 * @access public
 * @param mixed $side
 * @return void
 */
function rhd_byline( $side ) {
	$text = "&copy; 2009-2015 Centsational Girl, all rights reserved.<br />"
		. "Centsational Girl and Centsational are both legally registered trademarks.<br />"
		. "Site by <a href='//roundhouse-designs.com' target='_blank'>Roundhouse Designs</a>\n";

	$args = array(
		'before_title'	=> '',
		'after_title'	=> '',
		'before_widget' => "<div id='site-info-$side' class='site-info'>",
		'after_widget'  => '</div>'
	);

	$instance = array(
		'text' 		=> $text,
		'filter'	=> true
	);

	the_widget( 'WP_Widget_Text', $instance, $args );
}


/**
 * rhd_format_link_strip_tags function.
 *
 * @access public
 * @param mixed $content
 * @return void
 */
function rhd_format_link_strip_tags( $content ) {
	if ( has_post_format( 'link' ) )
		return $content;
	else
		return wpautop( $content );
}
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'rhd_format_link_strip_tags' );


/**
 * rhd_grid_more function.
 *
 * @access public
 * @param mixed $q
 * @param mixed $found_posts
 * @param mixed $link
 * @return void
 */
function rhd_grid_more( $link ) {
	$output = "<div class='ghost-button grid-more'>\n"
			. "<a href='$link'>Load More</a>\n"
			. "</div>";

	echo $output;
}


function rhd_social_shares() {
	global $post;

	$updir = wp_upload_dir();

	$title = $post->post_title;
	$link = get_permalink( $post->ID );
	$blogname = get_bloginfo( 'name' );

	$thumb_url = wp_get_attachment_thumb_url( $post->ID );
	$thumb_url = ( $thumb_url ) ? $thumb_url : $updir['baseurl'] . '/2015/10/fallback.jpg';

	$mailto = "mailto:centsationalgirl@gmail.com?subject=Centsational%20Girl%3A%20$title&body=$link";
	?>

	<div class="rhd-social-share-container">
		<p class="share-text">Share &rarr;</p>
		<ul class='rhd-social-share'>
			<li class='rhd-ss-item rhd-ss-item-facebook'>
				<a href='//www.facebook.com/share.php?u=<?php echo $link; ?>&title=<?php echo $title; ?>' target='_blank'>
					<img src='<?php echo RHD_IMG_DIR; ?>/social-share/facebook.png' alt="Share <?php echo $title; ?> on Facebook">
				</a>
			</li>

			<li class='rhd-ss-item rhd-ss-item-twitter'>
				<a href='//twitter.com/intent/tweet?status=<?php echo $title; ?>+<?php echo $link; ?>' target='_blank'>
					<img src='<?php echo RHD_IMG_DIR; ?>/social-share/twitter.png' alt="Share <?php echo $title; ?> on Twitter">
				</a>
			</li>

			<li class='rhd-ss-item rhd-ss-item-pinterest'>
				<a href='http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $thumb_url; ?>&url=<?php echo $link; ?>&is_video=false&description=<?php echo $title; ?>' target='_blank'>
					<img src='<?php echo RHD_IMG_DIR; ?>/social-share/pinterest.png' alt="Pin <?php echo $title; ?> on Pinterest">
				</a>
			</li>

			<li class='rhd-ss-item rhd-ss-item-google-plus'>
				<a href='//plus.google.com/share?url=<?php echo $link; ?>' target='_blank'>
					<img src='<?php echo RHD_IMG_DIR; ?>/social-share/google-plus.png' alt="Share <?php echo $title; ?> on Google+">
				</a>
			</li>

			<li class='rhd-ss-item rhd-ss-item-bloglovin'>
				<a href='//www.bloglovin.com/blogs/centsational-girl-726939' target='_blank'>
					<img src='<?php echo RHD_IMG_DIR; ?>/social-share/bloglovin.png' alt="Follow <?php echo $blogname; ?> on Bloglovin">
				</a>
			</li>

			<li class='rhd-ss-item rhd-ss-item-email'>
				<a href='<?php echo $mailto; ?>'>
					<img src='<?php echo RHD_IMG_DIR; ?>/social-share/email.png' alt="Share <?php echo $title; ?> by Email">
				</a>
			</li>
		</ul>
	</div>
	<?php
}


function rhd_filter_rss( $query ) {
	if ( is_feed() && $query->is_main_query() ) {
		$query->set( 'post_type', 'post' );
	}
}
add_action( 'pre_query_posts', 'rhd_filter_rss' );
