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
	// Constants and Globals
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
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic|Oswald:400,700' );

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
	wp_register_script( 'imagesloaded', RHD_THEME_DIR . '/js/vendor/imagesloaded/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.2.0', true );
	wp_register_script( 'rhd-roster-ajax', RHD_THEME_DIR . '/js/roster-ajax.js', array( 'jquery' ), null, true );
	wp_register_script( 'slidebars', RHD_THEME_DIR . '/js/vendor/Slidebars/dist/slidebars.min.js', array( 'jquery' ), '0.10.3', true );

	$main_deps = array(
		'rhd-plugins',
		'jquery',
		'modernizr',
		'slidebars',
		'imagesloaded',
	);
	wp_register_script( 'rhd-main', RHD_THEME_DIR . '/js/main.js', $main_deps, null, false );

	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'rhd-plugins' );
	wp_enqueue_script( 'rhd-roster-ajax' );
	wp_enqueue_script( 'rhd-main' );

	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );

	// Localize data for client-side use
	$data = array(
		'theme_dir' => RHD_THEME_DIR,
		'ajax_url' => admin_url( 'admin-ajax.php' ),
	);
	wp_localize_script( 'rhd-roster-ajax', 'roster', $data);
	wp_localize_script( 'rhd-main', 'data', $data );

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


/**
 * rhd_add_editor_styles function.
 *
 * @access public
 * @return void
 */
function rhd_add_editor_styles()
{
	//Google Fonts in admin editor
	$font_url = '//fonts.googleapis.com/css?family=Fanwood+Text|Julius+Sans+One';
	$font_url = str_replace( ',', '%2C', $font_url );
	$font_url = str_replace( ':', '%3A', $font_url );
    add_editor_style( $font_url );


	add_editor_style( RHD_THEME_DIR . '/css/editor.css' );
}
add_action( 'after_setup_theme', 'rhd_add_editor_styles' );


/* ==========================================================================
   Sidebars + Menus
   ========================================================================== */

/**
 * rhd_register_sidebars function.
 *
 * @access public
 * @return void
 */
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
		'id'			=> 'footer-widget-area',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Footer Widget Area (Right)', 'rhd' ),
		'id'			=> 'footer-widget-area-2',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>'
	));
}
add_action( 'widgets_init', 'rhd_register_sidebars' );


// Includes and Requires
//include_once( 'includes/rhd-admin-panel.php' );

register_nav_menu( 'primary', 'Main Site Navigation' );
register_nav_menu( 'slidebar', 'Slidebar Site Navigation' );
register_nav_menu( 'footer', 'Footer Site Navigation' );


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
	add_image_size( '4x6', 360, 280, array( 'left', 'top' ) );
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
//add_filter('login_headerurl', 'rhd_branding_login');


// Site Title as "login message" (underneath RHD logo)
function rhd_login_message() {
	echo '<h1 class="rhd-login-site-title">' . get_bloginfo('name') . "</h1>\n";
}
//add_action( 'login_message', 'rhd_login_message' );


// Roundhouse Branding CSS
function rhd_login()
{
	wp_enqueue_style( 'rhd_login', get_stylesheet_directory_uri() . '/rhd/rhd-login.css' );
}
//add_action('login_head', 'rhd_login');


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
 * @param obj $q (default: null)
 * @return void
 */
function rhd_archive_pagination( WP_Query $q = null )
{
	$max_page = ( $q ) ? $q->max_num_pages : null;

	$sep = ( get_previous_posts_link() != '' ) ? '<div class="pag-sep"></div>' : null;

	echo '<div class="pagination">';

	echo '<span class="pag-next">' . get_next_posts_link( '&larr; Older', $max_page ) . '</span>';

	if ( $sep ) {
		echo '<div class="pag-sep"></div>';
	}

	echo '<span class="pag-prev">' . get_previous_posts_link( 'Newer &rarr;' ) . '</span>';
	echo '</div>';
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
	$body_classes[] = ( get_query_var( 'pagename' ) == 'recent-events' ) ? 'no-image-strip' : '';

	if ( !session_id() )
		session_start();

	if ( get_post_type() != 'club_member' ) {
		if ( is_home() || is_single() || is_archive() || is_search() ) {
			$body_classes[] = 'blog-area';

			$_SESSION['blog_area'] = true;
		} else {
			$_SESSION['blog_area'] = false;
		}
	}

	return $body_classes;
}
add_filter( 'body_class', 'rhd_body_class' );


/* ==========================================================================
	Theme Functions and Customizations
   ========================================================================== */


/**
 * rhd_print_roster_table function.
 *
 * @access public
 * @param bool $current (default: false)
 * @return void
 */
function rhd_print_roster_table()
{
	global $post;

	$ltr = $_POST['letter'];
	$current = isset( $_POST['current'] ) ? $_POST['current'] : '';

	// Check if a range
	if ( stripos( $ltr, '-' ) ) {
		$i = 0;
		$r = explode( '-', $ltr );
		foreach ( range($r[0], $r[1] ) as $l ) {
			$new_ltr[$i] = $l;
			++$i;
		}
		$ltr = $new_ltr;
	}

	$args = array(
		'post_type' => 'club_member',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	);

	if ( $current ) {
		$args['tax_query'] = array(
			'relation' => 'AND',
			array(
				'terms' => $ltr,
				'taxonomy' => 'glossary',
				'field' => 'slug'
			),
			array(
				'taxonomy' => 'member_class',
				'field' => 'slug',
				'terms' => 'current-members'
			)
		);
	} else {
		$args['tax_query'] = array(
			array(
				'terms' => $ltr,
				'taxonomy' => 'glossary',
				'field' => 'slug'
			)
		);
	}

	$members = get_posts( $args );

	$key = ( is_array( $ltr ) ) ? implode( $ltr ) : $ltr;

	if ( $members ) {
		$output = "<div id='roster-area-container' data-roster-key='$key'>\n"
				. "<table id='roster-$key' class='roster-table'>"
				. "<tr>
					<th class='name'>Name</th>
					<th class='elected'>Year Elected</th>";

		if ( ! $current )
			$output .= "<th class='died'>Year Died</th>";

		$output .= "<th class='memb_type'>Membership Type</th>
					<th class='notes'>Notes</th>
				</tr>";

		foreach ( $members as $post ) {
			setup_postdata( $_GLOBALS['post'] =& $post );

			$terms = get_the_terms( $post->ID, 'membership_type' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$term_list = array();
				foreach ( $terms as $term ) {
					$term_list[] = $term->name;
				}

				$joined_terms = ( $term_list[0] == 'uncategorized' ) ? '' : join( ", ", $term_list );
			}

			if ( $post->post_content != ' ' && $post->post_content ) {
				$link = get_the_permalink();
				$target = "_self";
			} else {
				$link = do_shortcode( '[ct id="_ct_text_5638d53b1e9d4" property="value"]' );
				$target = "_blank";
			}

			$name = ( $link ) ? '<a href="' . $link . '" target="' . $target . '">' . get_the_title() . '</a>' : get_the_title();

			$output .= "<tr>"
					. "<td>" . $name . "</td>"
					. "<td>" . do_shortcode( '[ct id="_ct_text_56382e07e4c3a" property="value"]' ) . "</td>";

			if ( ! $current )
				$output .=  "<td>" . do_shortcode( '[ct id="_ct_text_56382e13b6858" property="value"]' ) . "</td>";

			$output .= "<td>$joined_terms</td>"
					. "<td>" . do_shortcode( '[ct id="_ct_text_5638d2dfbf87f" property="value"]' ) . "</td>"
					. "</tr>";
		}
		wp_reset_postdata();

		$output .= "</table>\n";

		$output .= '<span id="roster-link"><a href="javascript:;">View Roster: \'' . strtoupper( $key ) . "'</a></span>\n"
				. "</div>\n";
	} else {
		$output = '<p>Sorry, no members were found.</p>';
	}

	echo $output;
	die();
}
add_action( 'wp_ajax_nopriv_rhd_print_roster_table', 'rhd_print_roster_table' );
add_action( 'wp_ajax_rhd_print_roster_table', 'rhd_print_roster_table' );


/**
 * rhd_roster_save_glossary function.
 *
 * @access public
 * @param mixed $post_id
 * @return void
 */
function rhd_roster_save_glossary( $post_id )
{
	$title = get_the_title( $post_id );
	$ltr = strtolower( $title );

	$ltr = $ltr[0];

	wp_set_object_terms( $post_id, $ltr, 'glossary' );
}
add_action( 'save_post', 'rhd_roster_save_glossary' );


/**
 * rhd_print_awards_table function.
 *
 * @access public
 * @param mixed $award
 * @param mixed $title
 * @return void
 */
function rhd_print_awards_table( $award, $title )
{
	global $post;

	$args = array(
		'post_type' => 'club_member',
		'posts_per_page' => -1,
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_key' => $award
	);
	$members = get_posts( $args );

	if ( $members ) {
		$output = "<h3>$title</h3>"
				. "<table id='awards-$award' class='awards-table'>";

		foreach ( $members as $post ) {
			setup_postdata( $_GLOBALS['post'] =& $post );

			$meta = get_post_meta( $post->ID, $award, true );

			$rows = explode( PHP_EOL, $meta );

			foreach ( $rows as $row) {
				$data = explode( ';', $row );

				$title = explode( ',', $post->post_title );
				$title_fmtd = $title[1] . ' ' . $title[0];

				if ( $post->post_content != ' ' && $post->post_content ) {
					$link = get_the_permalink();
					$target = "_self";
				}
				else {
					$link = do_shortcode( '[ct id="_ct_text_5638d53b1e9d4" property="value"]' );
					$target = "_blank";
				}

				$name = ( $link ) ? '<a href="' . $link . '" target="' . $target . '">' . get_the_title() . '</a>' : get_the_title();

				$output .= "<tr>"
						. "<td>" . $data[0] . "</td>"
						. "<td>" . $name . "</td>"
						. "<td>" . $data[1] . "</td>"
						. "<td>" . $data[2] . "</td>"
						. "</tr>";
			}

			wp_reset_postdata();
		}

		$output .= "</table>";
	}

	echo $output;
}


/**
 * rhd_print_shepherds_table function.
 *
 * @access public
 * @return void
 */
function rhd_print_shepherds_table()
{
	global $post;

	$args = array(
		'post_type' => 'club_member',
		'posts_per_page' => -1,
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_key' => 'shepherd_years',
		'tax_query' => array(
			array(
				'taxonomy' => 'member_class',
				'terms' => 'shepherds',
				'field' => 'slug'
			)
		)
	);
	$members = get_posts( $args );

	if ( $members ) {
		$output = "<h3 style='text-align: center;'>Our Shepherds</h3>"
				. "<table id='tax-roster-table' class='shepherds-table'>";

		foreach ( $members as $post ) {
			setup_postdata( $_GLOBALS['post'] =& $post );

			$meta = get_post_meta( $post->ID, 'shepherd_years', true );

			$title = explode( ',', $post->post_title );
			$title_fmtd = $title[1] . ' ' . $title[0];

			if ( $post->post_content != ' ' && $post->post_content ) {
				$link = get_the_permalink();
				$target = "_self";
			}
			else {
				$link = do_shortcode( '[ct id="_ct_text_5638d53b1e9d4" property="value"]' );
				$target = "_blank";
			}

			$name = ( $link ) ? '<a href="' . $link . '" target="' . $target . '">' . get_the_title() . '</a>' : get_the_title();

			$output .= "<tr>"
					. "<td>" . $name . "</td>"
					. "<td>" . $meta . "</td>"
					. "</tr>";
		}
		wp_reset_postdata();
		$output .= "</table>";
	}

	echo $output;
}


/**
 * rhd_print_immortal_table function.
 *
 * @access public
 * @return void
 */
function rhd_print_immortal_table()
{
	global $post;

	$args = array(
		'post_type' => 'club_member',
		'posts_per_page' => -1,
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'member_class',
				'terms' => 'immortal-lambs',
				'field' => 'slug'
			)
		)
	);
	$members = get_posts( $args );

	if ( $members ) {
		$output = "<h3 style='text-align: center;'>Immortal Lambs</h3>"
				. "<table id='tax-roster-table' class='immortal-table'>"
				. "<tr>
					<th class='name'>Name</th>
					<th class='elected'>Year Elected</th>
					<th class='died'>Year Died</th>
					<th class='memb_type'>Membership Type</th>
					<th class='notes'>Notes</th>
					</tr>";

		foreach ( $members as $post ) {
			setup_postdata( $_GLOBALS['post'] =& $post );

			$title = explode( ',', $post->post_title );
			$title_fmtd = $title[1] . ' ' . $title[0];

			$terms = get_the_terms( $post->ID, 'membership_type' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$term_list = array();
				foreach ( $terms as $term ) {
					$term_list[] = $term->name;
				}

				$joined_terms = ( $term_list[0] == 'uncategorized' ) ? '' : join( ", ", $term_list );
			}

			if ( $post->post_content != ' ' && $post->post_content ) {
				$link = get_the_permalink();
				$target = "_self";
			}
			else {
				$link = do_shortcode( '[ct id="_ct_text_5638d53b1e9d4" property="value"]' );
				$target = "_blank";
			}

			$name = ( $link ) ? '<a href="' . $link . '" target="' . $target . '">' . $title_fmtd . '</a>' : $title_fmtd;

			$output .= "<tr>"
					. "<td>" . $name . "</td>"
					. "<td>" . do_shortcode( '[ct id="_ct_text_56382e07e4c3a" property="value"]' ) . "</td>"
					. "<td>" . do_shortcode( '[ct id="_ct_text_56382e13b6858" property="value"]' ) . "</td>"
					. "<td>$joined_terms</td>"
					. "<td>" . do_shortcode( '[ct id="_ct_text_5638d2dfbf87f" property="value"]' ) . "</td>"
					. "</tr>";
		}
		wp_reset_postdata();
		$output .= "</table>";
	}

	echo $output;
}


/**
 * rhd_title_format function.
 *
 * @access public
 * @param mixed $content
 * @return void
 */
function rhd_title_format( $content )
{
	return '%s';
}
add_filter( 'private_title_format', 'rhd_title_format' );
add_filter( 'protected_title_format', 'rhd_title_format' );


/**
 * rhd_search_results_ppp function.
 *
 * @access public
 * @return void
 */
function rhd_search_results_ppp()
{
	if ( is_search() )
	set_query_var( 'posts_per_page', -1 ); // or use variable key: posts_per_page
}
add_filter( 'pre_get_posts', 'rhd_search_results_ppp' );


/**
 * rhd_main_roster_init function.
 *
 * @access public
 * @return void
 */
function rhd_main_roster_init()
{
	$output = '<div id="roster-container">'
		. '<div id="roster-search-form">';

	ob_start();
	get_template_part( 'searchform', 'roster' );
	$output .= ob_get_contents();
	ob_get_clean();

	$output .= '</div>';

	$output .= '<div id="glossary-area" class="entry-content">';

	$alpha = array(
'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u-v','w','x-z'
	);

	$output .= '<ul id="roster-index">';

	foreach ( $alpha as $ltr ) {
		$output .= "<li class='roster-key roster-key-$ltr'>\n"
			. "<a href='#' data-key='$ltr'>" . strtoupper( $ltr ) . "</a>\n"
			. "</li>";
	}

	$output .= "</ul>"
		. '<div id="roster-table-container"></div>'
		. '</div>'
		. '</div>';

	return $output;
}
add_shortcode( 'main_roster', 'rhd_main_roster_init' );


/**
 * rhd_logout_nav_link function.
 *
 * @access public
 * @param mixed $items
 * @param mixed $args
 * @return void
 */
function rhd_logout_nav_link($items, $args)
{
	$theme_location = 'primary'; // Theme Location slug
	$existing_menu_item_db_id = 78490;
	$new_menu_item_db_id = 999999; // unique id number
	$label = 'Log out';
	$url = wp_logout_url( get_permalink() );

	if ( $theme_location !== $args->theme_location )
		return $items;

	$new_links = array();

	if ( is_user_logged_in() ) {

		// only if user is logged-in, do sub-menu link
		$item = array(
			'title'            => $label,
			'ID'               => 'log-out',
			'db_id'            => $new_menu_item_db_id,
			'url'              => $url,
			'classes'          => array( 'menu-item' )
		);

		$new_links[] = (object) $item;  // Add the new menu item to our array
		unset( $item ); // in case we add more items below

		$index = count( $items );  // integer, the order number.

		// Insert the new links at the appropriate place.
		array_splice( $items, $index, 0, $new_links );
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'rhd_logout_nav_link', 10, 2 );


// Add password reset link on member-login page
function rhd_password_reset_link( $content )
{
	global $post;
	if ( $post->post_name == 'member-login' ) {
		$content .= '<p style="text-align: center;"><a href="' . wp_lostpassword_url( get_permalink() . '?msg=check-email' ) . '" title="Lost Password"">Reset Your Password</a></p>';
	}
	return $content;
}
add_filter( 'the_content', 'rhd_password_reset_link' );


/**
 * check_app_quota_week function.
 *
 * @access public
 * @param mixed $reply_array
 * @return void
 */
function rhd_check_app_quota_week( $reply_array )
{
	if ( ! is_user_logged_in() )
		return $reply_array;

	global $current_user, $wpdb;

	$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "app_appointments WHERE status<>'removed' AND user=" . $current_user->ID . " AND WEEK(created)=WEEK(CURDATE()) " );

	if ( $count >= 8 ) {
		die( json_encode( array( 'error'=>'Sorry, your weekly appointment quota is full' ) ) );
	}
	return $reply_array;
}
add_filter( 'app_pre_confirmation_reply', 'rhd_check_app_quota_week' );


/**
 * check_app_quota_day function.
 *
 * @access public
 * @param mixed $reply_array
 * @return void
 */
function rhd_check_app_quota_day( $reply_array )
{
	if ( ! is_user_logged_in() )
		return $reply_array;

	global $current_user, $wpdb;

	$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "app_appointments WHERE status<>'removed' AND user=" . $current_user->ID . " AND DAY(created)=DAY(CURDATE()) " );

	if ( $count >= 4 ) {
		die( json_encode( array( 'error'=>'Sorry, your daily appointment quota is full' ) ) );
	}
	return $reply_array;
}
add_filter( 'app_pre_confirmation_reply', 'rhd_check_app_quota_day' );



/**
 * rhd_app_custom_header function.
 *
 * Alters the reply-to email address on Appointments+ sent mail
 *
 * @access public
 * @return void
 */
function rhd_app_custom_header()
{
	$admin_email = 'reservations@the-lambs.org';

	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$content_type = apply_filters('app-emails-content_type', 'text/plain');

	if (!(defined('APP_EMAIL_DROP_LEGACY_HEADERS') && APP_EMAIL_DROP_LEGACY_HEADERS)) {
		$message_headers = "MIME-Version: 1.0\n" .
		    "From: {$blogname}" .
		    " <{$admin_email}>\n" .
		    "Reply-To: <" . $blogname . "> <" . get_option( 'admin_email' ) . ">\n" .
		    "Content-Type: {$content_type}; charset=\"" . get_option('blog_charset') . "\"\n";
	} else {
		$message_headers = "MIME-Version: 1.0\n" .
		"Reply-To: <" . $blogname . "> <" . $admin_email . ">\n" .
		"Content-Type: {$content_type}; charset=\"" . get_option('blog_charset') . "\"\n";
		add_filter('wp_mail_from', create_function('', "return '{$admin_email}';"));
		add_filter('wp_mail_from_name', create_function('', "return '{$blogname}';"));
	}

	return $message_headers;
}
add_filter( 'app_message_headers', 'rhd_app_custom_header' );



/**
 * rhd_assign_membership_on_register function.
 *
 * @access public
 * @param mixed $user_id
 * @return void
 */
function rhd_assign_membership_on_register( $user_id )
{
	$membership_id = 78518;
	$member = MS_Factory::load( 'MS_Model_Member', $user_id );
	$subscription = $member->add_membership( $membership_id );

	if ( $member->has_membership() ) {
		$member->is_member = true;
	} else {
		$member->is_member = false;
	}
	$member->save();

}
add_action( 'user_register', 'rhd_assign_membership_on_register', 10, 1 );