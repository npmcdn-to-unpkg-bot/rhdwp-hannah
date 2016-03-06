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

function rhd_setup()
{
	// Constants
	define( "RHD_THEME_DIR", get_template_directory_uri() );
	define( "RHD_IMG_DIR", get_template_directory_uri() . '/img' );

	$updir = wp_upload_dir();
	define( "RHD_UPLOAD_URL", $updir['baseurl'] );
}
add_action( 'after_setup_theme', 'rhd_setup' );


/* Disable Editor */
define( 'DISALLOW_FILE_EDIT', true );


/* ==========================================================================
   Scripts + Styles
   ========================================================================== */

/**
 * rhd_enqueue_styles function.
 *
 * @access public
 * @return void
 */
function rhd_enqueue_styles()
{
	global $theme_opts;

	wp_register_style( 'rhd-main', RHD_THEME_DIR . '/css/main.css', array(), '1', 'all' );
	wp_register_style( 'rhd-enhanced', RHD_THEME_DIR . '/css/enhanced.css', array(), '1', 'all' );
	wp_register_style( 'slidebars', RHD_THEME_DIR . '/js/vendor/Slidebars/dist/slidebars.min.css', array(), '0.10.3', 'screen' );
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700,800,400italic' );

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


/**
 * rhd_enqueue_scripts function.
 *
 * @access public
 * @return void
 */
function rhd_enqueue_scripts()
{
	wp_register_script( 'modernizr', RHD_THEME_DIR . '/js/vendor/modernizr/modernizr.js', null, '3.3.1', false );
	wp_register_script( 'rhd-plugins', RHD_THEME_DIR . '/js/plugins.js', array( 'jquery' ), null, true );
	wp_register_script( 'slidebars', RHD_THEME_DIR . '/js/vendor/Slidebars/dist/slidebars.min.js', array( 'jquery' ), '0.10.3', true );
	wp_register_script( 'packery', RHD_THEME_DIR . '/js/vendor/packery/packery.pkgd.min.js', array( 'jquery' ), null, true );

	$main_deps = array(
		'rhd-plugins',
		'jquery',
		'modernizr',
		'slidebars',
		// 'packery',
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
 * rhd_add_editor_styles function.
 *
 * @access public
 * @return void
 */
function rhd_add_editor_styles()
{
	//Google Fonts in admin editor
	$font_url = '//fonts.googleapis.com/css?family=Open+Sans:400,700,800,400italic';
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
		'name'			=> __( 'Default Sidebar', 'rhd' ),
		'id'			=> 'sidebar',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Store Sidebar', 'rhd' ),
		'id'			=> 'sidebar-store',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Front Page Sidebar', 'rhd' ),
		'id'			=> 'sidebar-front-page',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	));

	register_sidebar(array(
		'name'			=> __( 'Footer Widget Area', 'rhd' ),
		'id'			=> 'footer-widget-area',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>'
	));
}
add_action( 'widgets_init', 'rhd_register_sidebars' );


// Menus

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

/**
 * rhd_theme_setup function.
 *
 * @access public
 * @return void
 */
function rhd_theme_setup()
{
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'infinite-scroll', array( 'container' => 'content', 'footer' => 'page' ) );

	register_nav_menu( 'primary', 'Main Site Navigation' );
	register_nav_menu( 'slidebar', 'Slidebar Site Navigation' );

	// Includes and Requires
	// include_once( 'includes/rhd-admin-panel.php' );
}
add_action( 'after_setup_theme', 'rhd_theme_setup' );


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


// Allow shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );


/**
 * rhd_image_sizes function.
 *
 * @access public
 * @return void
 */
function rhd_image_sizes()
{
	add_image_size( 'square', 300, 300, true );
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
function rhd_add_image_sizes( $sizes )
{
	$addsizes = array(
		"square" => __( "Square" )
	);
	$newsizes = array_merge( $sizes, $addsizes );

	return $newsizes;
}
add_filter( 'image_size_names_choose', 'rhd_add_image_sizes' );


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
		$excerpt_length = 40;
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
 * rhd_single_pagination function.
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
add_filter( 'widget_title', 'rhd_title_check_hidden' );


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

	//session_start();
	if ( is_home() || is_single() || is_archive() || is_search() ) {
		$body_classes[] = 'blog-area';

		$_SESSION['blog_area'] = true;
	} else {
		$_SESSION['blog_area'] = false;
	}

	return $body_classes;
}
add_filter( 'body_class', 'rhd_body_class' );


/* ==========================================================================
	Theme Functions and Customizations
   ========================================================================== */



/* ==========================================================================
	Widgets
   ========================================================================== */

/**
 * RHD_Store_Locations class.
 *
 * @extends WP_Widget
 */
class RHD_Store_Locations extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_store_locations_widget', // Base ID
			__('Store Locations Widget', 'rhd'), // Name
			array( 'description' => __( 'A list of all Stores, with addresses and phone numbers.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = ( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$title = ( $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : '';

		echo $before_widget;
		?>

		<h3 class="widget-title"><?php echo $title; ?></h3>

		<?php
		$store_args = array(
			'post_type' => 'store',
			'posts_per_page' => -1,
		);
		$stores = new WP_Query( $store_args );
		?>

		<?php if ( $stores->have_posts() ) : ?>

			<ul class="store-locations-list">

			<?php while ( $stores->have_posts() ) : $stores->the_post(); ?>

				<li class="store-location">

					<?php
					$addr = do_shortcode( '[ct id="ct_Address_textarea_e4cb" property="value"]' );
					$phone = do_shortcode( '[ct id="_ct_text_56d70df83ac98" property="value"]' );
					?>

					<h4 class="store-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<div class="store-info">
						<div class="store-address">
							<?php echo wpautop( $addr ); ?>
						</div>
						<a class="store-phone" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
					</div>

				</li>

			<?php endwhile; ?>

			</ul>

		<?php else : ?>
			<li class="store-location no-stores">
				<h3 class="store-name">No Stores Found</h3>
			</li>
		<?php endif;

		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['title'] = esc_attr( $instance['title'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $args['title']; ?>" >
		</p>

<?php
	}
}
function register_rhd_store_locations_widget()
{
    register_widget( 'RHD_Store_Locations' );
}
add_action( 'widgets_init', 'register_rhd_store_locations_widget' );


/**
 * RHD_Auto_Donation_Button class.
 *
 * @extends WP_Widget
 */
class RHD_Auto_Donation_Button extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_auto_donation_button_widget', // Base ID
			__('BUTTON: Auto Donation', 'rhd'), // Name
			array( 'description' => __( 'The "Auto Donation" Button.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['label'] = ( $new_instance['label'] ) ? strip_tags( $new_instance['label'] ) : 'Auto Donation';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$updir = wp_upload_dir();
		$label = ( $instance['label'] ) ? esc_attr( $instance['label'] ) : '';

		echo $before_widget;
		?>

		<div class="big-button big-button-auto-donation">
			<a class="big-button-link" href="<?php echo home_url( '/auto-donation' ); ?>">
				<object class="big-button-svg" id="big-button-car" type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri(); ?>/img/car.svg">
					<img class="big-button-image svg-fallback" src="<?php echo $updir['baseurl']; ?>/2016/03/car.png" alt="Auto Donation">
				</object>
				<p class="big-button-label"><?php echo $label; ?></p>
			</a>
		</div>

		<?php
		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['label'] = esc_attr( $instance['label'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label: ' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo $args['label']; ?>" >
		</p>

<?php
	}
}
function register_rhd_auto_donation_button_widget()
{
    register_widget( 'RHD_Auto_Donation_Button' );
}
add_action( 'widgets_init', 'register_rhd_auto_donation_button_widget' );


/**
 * RHD_Volunteer_Button class.
 *
 * @extends WP_Widget
 */
class RHD_Volunteer_Button extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_volunteer_button_widget', // Base ID
			__('BUTTON: Volunteer', 'rhd'), // Name
			array( 'description' => __( 'The "Volunteer" Button.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['label'] = ( $new_instance['label'] ) ? strip_tags( $new_instance['label'] ) : 'Volunteer';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$updir = wp_upload_dir();
		$label = ( $instance['label'] ) ? esc_attr( $instance['label'] ) : '';

		echo $before_widget;
		?>

		<div class="big-button big-button-volunteer">
			<a class="big-button-link" href="<?php echo home_url( '/volunteer' ); ?>"></a>
			<svg class="big-button-svg" id="big-button-bird" viewBox="0 0 608 608" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			        <g id="bird" transform="translate(4.000000, 4.000000)">
			            <circle stroke="#1E2171" stroke-width="8" fill="#FFFFFF" cx="300" cy="300" r="300"></circle>
			            <path d="M209.166711,250.646832 C253.053477,208.095088 298.031604,227.55606 336.137221,204.858881 C337.088328,241.283699 298.325264,243.645255 280.3682,245.442662 C273.697306,246.107396 274.959604,251.263461 281.446413,251.635187 C340.818243,255.011338 395.969264,256.563843 422.744881,249.750316 C431.892157,247.414999 427.798455,265.498397 409.017391,269.473683 C382.763349,275.023341 353.213306,274.052479 325.929264,273.155962 C321.89254,273.020391 317.895264,272.889193 314.288072,272.788609 C312.854838,272.753623 311.675817,273.873175 311.63637,275.303229 C311.59254,276.724536 312.718966,277.918434 314.1522,277.95342 C318.188923,278.058378 321.949519,278.189575 325.767094,278.3164 C356.899391,279.335367 382.684455,280.056954 411.712923,274.013119 C422.556413,272.294431 408.771945,287.937555 400.194455,290.281618 C372.099562,295.853141 346.616923,294.602391 316.203434,293.605289 C312.157945,293.469719 308.169434,293.342894 304.553477,293.24231 C303.124626,293.198577 301.932455,294.322503 301.893009,295.748183 C301.849179,297.178237 302.988753,298.363388 304.417604,298.402747 C308.441179,298.512079 312.219306,298.638903 316.036881,298.765727 C344.609519,299.049989 366.642753,300.449429 392.686413,296.360438 C401.987094,294.899772 391.441647,309.95688 383.236711,311.574983 C357.583136,316.604223 331.583306,314.881162 306.460072,314.054617 C302.423349,313.919046 298.421689,313.783476 294.818881,313.691637 C293.394413,313.652278 292.193477,314.776204 292.162796,316.201884 C292.127732,317.623191 293.25854,318.812716 294.678626,318.856448 C298.715349,318.965779 302.484711,319.092604 306.297902,319.215055 C328.199647,319.936641 351.201519,320.037226 373.629221,318.156728 C378.744157,317.728149 374.663604,324.607275 357.552455,328.705012 C343.163136,332.151135 313.402711,335.461687 286.372881,333.69052 C225.331136,329.71086 213.080711,345.030363 204.893306,384.96253 C175.018923,340.062348 164.425264,294.020748 209.166711,250.646832" id="Fill-51" fill="#222B78"></path>
			            <path d="M397.497609,236.032298 C397.497609,236.032298 467.296545,237.820958 492.213779,210.094539 C517.131013,182.363746 500.488843,167.77895 487.414417,169.313961 C474.339991,170.848973 460.770289,182.350626 460.770289,182.350626 C460.770289,182.350626 487.383736,140.419883 464.333651,137.800305 C424.812332,133.291482 397.497609,236.032298 397.497609,236.032298" id="Fill-52" fill="#ED1867"></path>
			            <path d="M369.269472,251.17206 C383.062706,240.278289 383.869174,232.318969 379.407302,234.859829 C367.025387,241.892019 354.104366,248.298833 341.170196,254.220217 C349.366366,254.421386 357.27326,254.530718 364.790068,254.508851 C366.424919,253.33682 367.958962,252.204147 369.269472,251.17206" id="Fill-53" fill="#639DD4"></path>
			            <path d="M321.861421,234.59962 C347.760443,223.66649 369.982145,214.268371 391.769932,198.419704 C398.554783,192.695117 404.467421,172.718101 395.355209,178.831907 C376.350613,192.940019 357.398613,202.25942 335.935166,211.626926 C334.563294,222.516324 329.093336,229.74531 321.861421,234.59962" id="Fill-54" fill="#639DD4"></path>
			            <path d="M281.566945,251.633438 C298.09954,252.573687 314.29903,253.373992 329.652604,253.885663 C348.753626,245.865118 368.104477,237.346023 385.347115,224.851641 C392.110051,219.953599 395.33154,201.865827 387.516689,207.08749 C365.606179,221.724766 345.014945,229.692831 318.966902,241.426267 C315.44737,242.917546 311.971668,244.386959 308.285583,245.970076 C306.975072,246.534226 305.44103,245.930717 304.875626,244.618741 C304.389115,243.490442 304.814264,242.239692 305.76537,241.548718 C296.5392,244.037099 287.10703,244.780552 280.493115,245.440913 C273.809072,246.11002 275.084519,251.266085 281.566945,251.633438" id="Fill-55" fill="#639DD4"></path>
			            <path d="M336.251617,205.859481 C355.523574,197.379745 374.874426,187.885414 390.986255,175.850224 C406.361745,164.36169 402.460894,146.23456 395.132553,152.190929 C373.721702,169.596473 323.019404,191.322791 267.723745,213.167186 C261.692766,215.563728 258.88766,212.143845 264.142851,208.002375 C275.928681,198.726707 313.854596,180.442139 297.641957,147.791437 C275.924298,179.558742 236.104936,184.671074 211.665447,222.81458 C215.29017,225.709673 220.036936,230.257856 225.783021,237.39063 C264.31817,212.305655 302.919064,224.721318 336.256,204.858006 C336.264766,205.203493 336.242851,205.522741 336.251617,205.859481" id="Fill-56" fill="#639DD4"></path>
			            <path d="M131.604204,208.088965 C129.745821,210.061302 129.855396,213.175058 131.840885,215.02057 C133.821991,216.874829 136.938289,216.769871 138.787906,214.793161 C140.641906,212.812078 140.536715,209.702695 138.551226,207.848436 C136.574502,206.002924 133.462587,206.107882 131.604204,208.088965 M116.4128,214.552632 C121.023694,213.153191 122.338587,203.400839 134.759949,196.810347 C147.176928,190.22423 179.128843,206.672031 197.537353,220.159141 C201.933481,223.386602 206.307694,226.688407 210.361949,230.335699 C211.751353,231.590823 214.920247,233.991738 215.152545,236.07778 C215.279651,236.668169 206.171821,243.547295 205.24263,244.448185 C188.113949,260.965958 176.582332,281.54211 172.247566,304.899651 C172.181821,305.28887 171.747906,310.34435 171.467396,310.453681 C171.467396,310.453681 167.540247,311.966827 166.42697,294.583149 C165.07263,273.630897 138.538077,233.309511 122.426247,228.665117 C112.99846,225.953701 100.914587,223.565905 96.4439489,224.081949 L95.9881191,223.49156 C98.0305872,222.529444 112.148162,215.851488 116.4128,214.552632" id="Fill-57" fill="#639DD4"></path>
			            <path d="M338.605715,463.80046 C366.459545,458.054007 419.625077,443.311773 411.946098,440.202391 C381.032949,427.677397 356.365545,409.401575 338.21563,391.956672 C314.863119,369.504395 302.323417,348.429692 301.196991,342.761957 C298.440098,342.460203 295.525417,342.342125 292.544991,341.913546 C271.980055,338.983467 254.474438,338.703579 239.283034,345.302817 C227.076438,350.603198 218.954779,363.613624 215.058311,375.976808 C213.83546,379.847136 212.76163,385.536738 211.766694,390.0718 C208.808183,403.506431 272.019502,404.442307 277.712991,404.577878 C297.936055,405.076429 310.033077,409.698956 319.561672,427.261938 C321.196523,430.270735 336.861289,464.16344 338.605715,463.80046" id="Fill-58" fill="#639DD4"></path>
			        </g>
			    </g>
			</svg>
			<p class="big-button-label"><?php echo $label; ?></p>
		</div>

		<?php
		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['label'] = esc_attr( $instance['label'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label: ' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo $args['label']; ?>" >
		</p>

<?php
	}
}
function register_rhd_volunteer_button_widget()
{
    register_widget( 'RHD_Volunteer_Button' );
}
add_action( 'widgets_init', 'register_rhd_volunteer_button_widget' );


/**
 * RHD_Schedule_Pickup_Button class.
 *
 * @extends WP_Widget
 */
class RHD_Schedule_Pickup_Button extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_schedule_pickup_button_widget', // Base ID
			__('BUTTON: Schedule Pickup', 'rhd'), // Name
			array( 'description' => __( 'The "Schedule Pickup" Button.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['label'] = ( $new_instance['label'] ) ? strip_tags( $new_instance['label'] ) : 'Schedule Pickup';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$updir = wp_upload_dir();
		$label = ( $instance['label'] ) ? esc_attr( $instance['label'] ) : '';

		echo $before_widget;
		?>

		<div class="big-button big-button-schedule-pickup">
			<a class="big-button-link" href="<?php echo home_url( '/schedule-pickup' ); ?>"><img class="big-button-image svg-fallback" src="<?php echo $updir['baseurl']; ?>/2016/03/truck.png" alt="Schedule Pickup"></a>
			<svg class="big-button-svg" id="big-button-truck" viewBox="0 0 608 608" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			        <g id="truck" transform="translate(3.000000, 3.000000)">
			            <g id="Group-6" transform="translate(0.559375, 0.048980)">
			                <circle stroke="#1E2171" stroke-width="8" fill="#FFFFFF" cx="300.440625" cy="300.95102" r="300"></circle>
			                <path d="M96.8521583,343.317537 L96.8521583,348.938047 C94.2966188,350.015729 91.0168427,352.055041 91.0168427,355.08511 L91.0168427,364.04971 C91.0168427,365.912898 92.6633313,368.976645 95.2293406,370.054327 L95.2293406,377.781049 L119.040833,377.781049 C119.051758,377.721431 119.073153,377.680471 119.083623,377.624494 L119.226103,376.884498 C121.25087,367.101169 127.268724,358.189816 136.575914,352.751347 L136.732505,352.637571 C154.136941,342.590739 176.37842,348.481124 186.518641,365.828249 C189.573089,371.054186 191.185436,376.737045 191.471762,382.391233 L351.376435,382.391233 L351.376435,343.317537 L96.8521583,343.317537 L96.8521583,343.317537 Z M373.180915,236.582455 L442.622491,236.582455 C442.746307,236.683033 442.869214,236.764041 443.006686,236.852786 L443.020798,236.852786 L471.942004,283.809759 L373.180915,283.809759 L373.180915,236.582455 L373.180915,236.582455 Z M354.436346,229.410957 L354.436346,382.391233 L398.259252,382.391233 C398.882432,370.522171 405.262177,359.194682 416.291875,352.751347 L416.477145,352.637571 C433.88158,342.590739 456.122149,348.481124 466.26328,365.828249 C469.317273,371.054186 470.929621,375.683939 471.215947,381.338582 L513.572627,381.338582 L513.572627,368.517902 L514.085192,368.517902 C516.501437,368.517902 518.440625,366.565514 518.440625,364.149378 L518.440625,345.252631 C518.440625,342.836494 516.501437,340.884106 514.085192,340.884106 L512.960827,340.884106 C512.723664,340.27518 512.305782,338.916245 511.708549,337.440804 C509.800771,332.728222 508.638169,328.878969 507.76599,325.658667 C506.450437,320.800908 505.267351,317.076353 503.737851,313.748647 C502.472827,310.99528 501.033914,308.499955 497.81468,304.293902 C494.595447,300.089214 489.328686,294.219763 481.549176,284.43598 L450.42203,234.248692 C449.45016,232.892488 448.755968,231.224084 447.46181,230.435392 L447.447699,230.422194 C445.959623,229.689935 444.74103,229.740906 443.291647,229.653527 L375.885307,229.653527 L354.436346,229.410957 L354.436346,229.410957 Z" id="Fill-101" fill="#222B78"></path>
			                <path d="M155.281334,365.362224 C151.995641,365.293959 148.647583,366.095849 145.594501,367.858004 L145.511653,367.90852 C136.624621,373.101235 133.628895,384.510643 138.823277,393.396055 C144.017204,402.281467 155.430188,405.276949 164.31722,400.082869 C173.204252,394.890155 176.199523,383.480747 171.005596,374.595335 C167.609742,368.786412 161.554105,365.492384 155.280879,365.363135 L155.281334,365.362224 L155.281334,365.362224 Z M154.787433,356.040369 C164.435119,356.003961 173.838813,360.970945 179.054134,369.891855 C186.845025,383.219518 182.352119,400.339092 169.021343,408.128163 C155.690567,415.91678 138.566995,411.424922 130.776104,398.098169 C122.985214,384.770506 127.47812,367.650478 140.809351,359.861861 L140.932713,359.784494 C145.304078,357.262318 150.076027,356.054478 154.787889,356.038549 L154.787433,356.040369 L154.787433,356.040369 Z" id="Fill-103" fill="#222B78"></path>
			                <path d="M147.660236,371.814661 C140.755181,375.662549 138.337115,384.2749 142.258734,391.050004 C146.180354,397.826018 154.957681,400.198465 161.862281,396.350578 C168.767336,392.502235 171.185403,383.889884 167.263328,377.11478 C163.356275,370.363796 154.625834,367.979516 147.725786,371.778253" id="Fill-104" fill="#222B78"></path>
			                <path d="M435.391051,365.362224 C432.104902,365.293959 428.756845,366.095849 425.703763,367.858004 L425.621825,367.90852 C416.734793,373.101235 413.739522,384.510643 418.933449,393.396055 C424.127376,402.281467 435.540359,405.276949 444.427392,400.082869 C453.314424,394.890155 456.309695,383.480747 451.115768,374.595335 C447.720369,368.786412 441.664732,365.492384 435.391506,365.363135 L435.391051,365.362224 L435.391051,365.362224 Z M434.896695,356.040369 C444.54438,356.003961 453.948074,360.970945 459.162941,369.891855 C466.954286,383.219518 462.460925,400.339092 449.130149,408.128163 C435.799373,415.91678 418.676256,411.424922 410.885366,398.098169 C403.09402,384.770506 407.587381,367.650478 420.918157,359.861861 L421.041519,359.784494 C425.412884,357.262318 430.184833,356.054478 434.896695,356.038549 L434.896695,356.040369 L434.896695,356.040369 Z" id="Fill-105" fill="#222B78"></path>
			            </g>
			            <path d="M428.328418,371.863641 C421.421086,375.707433 418.996192,384.317963 422.913259,391.095343 C426.829872,397.874088 435.604923,400.252906 442.512709,396.409114 C449.420496,392.566233 451.844935,383.955702 447.928323,377.177412 C444.025822,370.424608 435.297202,368.033047 428.394423,371.827233" id="Fill-107" fill="#222B78"></path>
			            <path d="M181.356502,245.856353 L173.483674,245.884114 L173.483674,257.03639 L180.8494,257.03639 C183.842395,257.03639 186.304161,256.995431 188.108152,256.903045 C189.912143,256.81612 191.127549,256.617696 191.390659,256.529406 L191.444374,256.529406 C192.641572,256.12391 193.25929,255.634676 193.819651,254.820953 C194.387296,253.963996 194.673622,253.035133 194.673622,251.512816 C194.673622,249.823933 194.294433,248.726682 193.579301,247.911139 C192.805902,247.013678 191.816279,246.414308 190.243534,246.149894 L190.19073,246.149894 C189.509283,246.056598 186.369256,245.856353 181.356957,245.856353 L181.356502,245.856353 L181.356502,245.856353 Z M279.325074,231.36909 L325.307489,231.36909 C326.476008,231.36909 327.548934,232.414004 327.548934,233.582706 L327.548934,243.641371 C327.548934,244.808708 326.476464,245.855898 325.307489,245.855898 L294.056526,245.855898 L294.056526,255.915018 L323.065588,255.915018 C324.234107,255.915018 325.307489,256.988604 325.307489,258.155031 L325.307489,268.186845 C325.307489,269.353727 324.26142,270.429133 323.09199,270.429133 L294.056526,270.429133 L294.056526,282.700959 L326.428211,282.700959 C327.596731,282.700959 328.643255,283.776365 328.643255,284.943247 L328.643255,294.974606 C328.643255,296.140578 327.598097,297.215073 326.428211,297.215073 L279.538567,297.215073 C278.370047,297.215073 277.297121,296.140578 277.297121,294.974606 L277.297121,233.580886 C277.297121,232.479084 278.226656,231.466937 279.325074,231.367269 L279.325074,231.36909 L279.325074,231.36909 Z M158.752222,231.36909 L185.439721,231.36909 C192.174073,231.36909 197.122643,231.695398 200.67782,232.996535 L200.67782,233.024296 C204.092338,234.294486 206.982,236.54451 209.030893,239.774369 C211.062488,242.996492 212.099907,246.711035 212.099907,250.740053 C212.099907,255.85449 210.545826,260.325412 207.429925,263.786463 C205.252664,266.202145 202.304279,267.867818 198.836502,268.9901 C199.909428,269.840231 200.915439,270.742243 201.798998,271.684759 C203.716335,273.746371 206.15079,276.947104 209.191581,281.849918 C209.205238,281.85902 209.182932,281.901345 209.191581,281.901345 L216.7708,293.747651 C217.648897,295.091112 216.506779,297.24329 214.902625,297.24329 L199.904421,297.24329 C199.176088,297.24329 198.444113,296.858273 198.036246,296.256173 L188.962578,282.942163 L188.962578,282.914402 C185.778851,278.148573 183.544233,275.206339 182.584654,274.191006 L182.530484,274.191006 C181.518556,273.106043 180.562619,272.448876 179.674962,272.136676 L179.64856,272.136676 C178.797321,271.829027 176.854492,271.522743 174.09775,271.522743 L173.484129,271.522743 L173.484129,294.975516 C173.484129,296.142398 172.411658,297.215984 171.242228,297.215984 L158.96617,297.215984 C157.79765,297.215984 156.724269,296.141488 156.724269,294.975516 L156.724269,233.581796 C156.724269,232.480904 157.65517,231.466937 158.752677,231.36818 L158.752222,231.36909 L158.752222,231.36909 Z M106.285365,231.36909 L148.931102,231.36909 C150.099167,231.36909 151.146146,232.414004 151.146146,233.582706 L151.146146,243.641371 C151.146146,244.809618 150.07322,245.855898 148.9047,245.855898 L120.989959,245.855898 L120.989959,255.915018 L144.44821,255.915018 C145.617641,255.915018 146.689656,256.988604 146.689656,258.155031 L146.689656,269.308671 C146.689656,270.476008 145.617185,271.522743 144.44821,271.522743 L120.989959,271.522743 L120.989959,294.975516 C120.989959,296.141488 119.916578,297.215984 118.748514,297.215984 L106.472,297.215984 C105.30257,297.215984 104.256956,296.141488 104.256956,294.975516 L104.256956,233.581796 C104.256956,232.479994 105.187402,231.466937 106.285365,231.36818 L106.285365,231.36909 L106.285365,231.36909 Z M221.280549,231.341784 L267.262508,231.341784 C268.431028,231.341784 269.477552,232.414914 269.477552,233.582706 L269.477552,243.61452 C269.477552,244.780492 268.431028,245.855898 267.262508,245.855898 L235.985144,245.855898 L235.985144,255.887257 L265.020607,255.887257 C266.190038,255.887257 267.262508,256.960843 267.262508,258.128635 L267.262508,264.158282 C267.382228,264.259769 267.488292,264.401761 267.609377,264.505069 C267.495575,264.532831 267.379952,264.522818 267.262508,264.556041 L267.262508,268.184114 C267.262508,269.351906 266.190038,270.426402 265.020607,270.426402 L235.985144,270.426402 L235.985144,282.698229 L269.477552,282.698229 C270.646072,282.698229 271.719453,283.773635 271.719453,284.940516 L271.719453,294.972331 C271.719453,296.137847 270.646982,297.212343 269.477552,297.212343 L221.467184,297.212343 C220.298665,297.212343 219.252141,296.138757 219.252141,294.972331 L219.252141,233.578155 C219.252141,232.476353 220.181221,231.464206 221.280549,231.364994 L221.280549,231.337233 L221.280549,231.341784 L221.280549,231.341784 Z M82,339.265592 L350.900211,339.265592 L350.900211,189.319482 L82,189.319482 L82,339.265592 Z" id="Fill-108" fill="#639DD4"></path>
			        </g>
			    </g>
			</svg>
			<p class="big-button-label"><?php echo $label; ?></p>
		</div>

		<?php
		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['label'] = esc_attr( $instance['label'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label: ' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo $args['label']; ?>" >
		</p>

<?php
	}
}
function register_rhd_schedule_pickup_button_widget()
{
    register_widget( 'RHD_Schedule_Pickup_Button' );
}
add_action( 'widgets_init', 'register_rhd_schedule_pickup_button_widget' );


/**
 * rhd_post_meta_links function.
 *
 * @access public
 * @return void
 */
function rhd_post_meta_links()
{
	?>
	<ul class="post-meta">
		<li class="post-meta-item post-locations">
			<span class="post-meta-item-title">Store Locations</span><br />
			<?php echo get_the_term_list( get_the_ID(), 'location', '', '<br />', null ); ?>
		</li>
		<li class="post-meta-item post-cats">
			<span class="post-meta-item-title">Categories</span><br />
			<?php the_category( '<br />' ); ?>
		</li>
		<li class="post-meta-item post-tags">
			<span class="post-meta-item-title">Tags</span><br />
			<?php the_tags( '', '<br />' ); ?>
		</li>
	</ul>
	<?php
}