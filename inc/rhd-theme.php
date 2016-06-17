<?php
/**
 * RHD Theme Customizations
 *
 * ROUNDHOUSE DESIGNS
 *
 * Add all theme customization functions here.
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


/* ==========================================================================
	Constants and Includes
   ========================================================================== */

define( 'RHD_LOGO_SRC', RHD_UPLOAD_URL . '/2016/05/logo.png' );


/* ==========================================================================
	Functions
   ========================================================================== */

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
	$body_classes[] = ( wp_is_mobile() && ! rhd_is_mobile() ) ? 'tablet' : '';
	$body_classes[] = ( ! wp_is_mobile() && ! rhd_is_mobile() ) ? 'desktop' : '';

	session_start();

	if ( is_home() || is_single() || is_archive() || is_search() ) {
		$body_classes[] = 'blog-area';

		$_SESSION['blog_area'] = true;
	} else {
		$_SESSION['blog_area'] = false;
	}

	session_write_close();

	return $body_classes;
}
add_filter( 'body_class', 'rhd_body_class' );


/**
 * rhd_custom_excerpt_length function.
 *
 * @access public
 * @param mixed $length
 * @return void
 */
function rhd_custom_excerpt_length( $length)
{
	return 40;
}
add_filter( 'excerpt_length', 'rhd_custom_excerpt_length' );


/**
 * rhd_custom_excerpt_read_more function.
 *
 * @access public
 * @param mixed $more
 * @return void
 */
function rhd_custom_excerpt_read_more( $more )
{
	global $post;

	return rhd_ghost_button( 'Read More', get_permalink( $post ), null, 'center', true, false );
}
add_filter( 'excerpt_more', 'rhd_custom_excerpt_read_more' );


/**
 * rhd_navbar_search_form function.
 *
 * @access public
 * @return void
 */
function rhd_navbar_search_form()
{
	$output = '
		<form method="get" class="search-form" action="' . esc_url( home_url('/') ) . '">
			<div>
				<input type="text" value="" class="search-field" name="s" />
				<input type="submit" class="search-submit" value="" />
			</div>
			<a class="close-search" href="#">X</a>
		</form>
	';
	
	echo $output;
}


/**
 * rhd_picture_frame function.
 * 
 * @access public
 * @param mixed $img_tag
 * @param mixed $class (default: null)
 * @return void
 */
function rhd_picture_frame( $img_tag, $class = null )
{	
	?>
	<div class="rhd-picture-frame">
		<div class="framed-picture">
			<?php echo $img_tag; ?>
		</div>
		<img class="frame" src="<?php echo RHD_IMG_DIR; ?>/picture-frame.png" alt="picture frame">
	</div>
	<?php
}


/**
 * rhd_site_intro function.
 * 
 * @access public
 * @return void
 */
function rhd_site_intro()
{
	?>
	<div class="site-intro">
		<div class="intro-thumbnail">
			<?php $front = get_option( 'page_on_front' ); ?>
			<?php if ( has_post_thumbnail( $front ) ) : ?>
				<?php rhd_picture_frame( get_the_post_thumbnail( $front, 'large' ), 'intro-image' ); ?>
			<?php endif ;?>
		</div>
		
		<div class="intro-content-container">
			<div class="intro-hi">Hi!</div>
			<div class="intro-content">
				<?php
				$front_post = get_post( $front );
				
				echo apply_filters( 'the_content', $front_post->post_content ); ?>
			</div>
		</div>
	</div>
	<?php
}


/**
 * Append the Post's Custom Field values onto the end of the content
 *
 * @param string $pcontent Post Content
 * @param WP_Post $post WordPress Post
 * @param array $data Slider Data
 * @return string $pcontent;
 */
function soliloquy_featured_content_display_custom_fields( $pcontent, $post, $data )
{
	$author_id = $post->post_author;
	$date = '<span class="rhd-fc-date">' . get_the_time( get_option( 'date_format' ),  $post->ID ) . '</span>';
	
	// Remove actual post content from display
	$pcontent = '';

	// Append custom field values to the existing content
	// Amend as necessary
	$pcontent = $date;

	return $pcontent;
}
add_filter( 'soliloquy_fc_post_content', 'soliloquy_featured_content_display_custom_fields', 10, 3 );