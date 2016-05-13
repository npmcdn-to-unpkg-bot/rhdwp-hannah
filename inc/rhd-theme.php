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

	if ( is_home() || is_single() || is_archive() || is_search() || is_page( 12053 ) ) {
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
	return 35;
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

	return ' [...]' . rhd_ghost_button( 'Read More', get_permalink( $post ), null, 'center', false, false ) . '</p>';
}
add_filter( 'excerpt_more', 'rhd_custom_excerpt_read_more' );


function rhd_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'rhd_remove_more_link_scroll' );


/**
 * rhd_custom_content_read_more function.
 *
 * @access public
 * @return void
 */
function rhd_custom_content_read_more()
{
	global $post;

	return rhd_ghost_button( 'Read More', get_permalink( $post ), null, 'center', false, false );
}
add_filter( 'the_content_more_link', 'rhd_custom_content_read_more' );


/**
 * rhd_front_page_slider function.
 *
 * @access public
 * @return void
 */
function rhd_front_page_slider()
{
	?>
	<section id="front-page-slider">
		<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( 'front-page-slider', 'slug' ); } ?>
		<div class="scroll-label"><img class="vee" src="<?php echo RHD_IMG_DIR; ?>/d-caret.png" alt="scroll indicator"></span>Scroll<img class="vee" src="<?php echo RHD_IMG_DIR; ?>/d-caret.png" alt="scroll indicator"></div>
	</section>
	<?php
}


/**
 * rhd_header_message function.
 *
 * @access public
 * @return void
 */
function rhd_front_page_header_message()
{
	global $post;

	$has_thumb = ( has_post_thumbnail() ) ? true : false;

	if ( $has_thumb ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb = wp_get_attachment_image_src( $thumb_id, 'full', true );
		$thumb_output = 'style="background-image: url(' . $thumb[0] . ');"';
	} else {
		$thumb_output = '';
	}
	?>
	<section id="header-message-container">
		<div class="header-message">

			<?php if ( $has_thumb ) : ?>
				<?php
				$thumb_id = get_post_thumbnail_id( $post->ID );
				$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full' );
				?>

				<div class="header-message-photo" style="background-image: url( <?php echo $thumb_url[0]; ?> );"></div>
			<?php endif; ?>

			<div class="header-message-content">
				<div class="message-inner">
					<span class="message">
						EVERY HOUSE,<br />
						EVERY BUILDING,<br />
						EVERY SPACE TELLS<br />
						A STORY. IS YOUR<br />
						HOME TELLING<br />
						YOURS?
					</span>
					<div class="message-buttons">
						<?php rhd_ghost_button( 'Portfolio', home_url( '/portfolio' ), null, 'left', false, true ); ?>
						<?php rhd_ghost_button( 'Services', home_url( '/services' ), null, 'right', false, true ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
}


/**
 * rhd_front_page_instagram function.
 *
 * @access public
 * @return void
 */
function rhd_front_page_instagram()
{
	?>
	<section id="front-page-instagram">
		<h3 class="section-title"><a href="//instagram.com/copper_dot" target="_blank">Instagram</a></h3>
		<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '12119' ); } ?>
	</section>
	<?php
}


/**
 * rhd_add_query_vars function.
 *
 * @access public
 * @param mixed $query_vars
 * @return void
 */
function rhd_add_query_vars( $query_vars )
{
	$query_vars[] = '_is_blog_loop';
	return $query_vars;
}
add_filter( 'query_vars', 'rhd_add_query_vars' );


/**
 * rhd_blog_query_offset function.
 *
 * @access public
 * @param mixed $query
 * @return void
 */
function rhd_blog_query_offset( $query )
{
	if ( !isset( $query->query_vars['_is_blog_loop'] ) )
		return;

	$ppp = get_option( 'posts_per_page' );
	$offset = 1;

	if ( ! $query->is_paged ) { // First page
		$query->set( 'posts_per_page', $ppp + $offset );
	} else {
		$page_offset = $offset + ( ( $query->query_vars['paged'] - 1) * $ppp );

		$query->set( 'offset', $page_offset );
	}
}
add_action( 'pre_get_posts', 'rhd_blog_query_offset' );


/**
 * rhd_gallery_shortcode function.
 *
 * @access public
 * @param string $output (default: '')
 * @param mixed $attr
 * @param mixed $instance
 * @return void
 * @link http://robido.com/wordpress/wordpress-gallery-filter-to-modify-the-html-output-of-the-default-gallery-shortcode-and-style/
 */
function rhd_gallery_shortcode( $output = '', $attr, $instance )
{
	// Initialize
	global $post, $wp_locale;

	// Gallery instance counter
	static $instance = 0;
	$instance++;

	// Validate the author's orderby attribute
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
	}

	// Get attributes from shortcode
	$html5 = current_theme_supports( 'html5', 'gallery' );
    extract( shortcode_atts( array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => $html5 ? 'figure'     : 'dl',
        'icontag'    => $html5 ? 'div'        : 'dt',
        'captiontag' => $html5 ? 'figcaption' : 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ), $attr ) );


	// Initialize
	$id = intval( $id );

	if ( ! empty( $include ) ) {

		// Include attribute is present
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		// Setup attachments array
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}

	} else if ( ! empty( $exclude ) ) {

		// Exclude attribute is present
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );

		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) ) return '';

	// Filter gallery differently for feeds
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	// Filter tags and attributes
	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$icontag = tag_escape( $icontag );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}
	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = "gallery-{$instance}";

	$gallery_style = '';

	// Filter gallery CSS
	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	// Iterate through the attachments in this gallery instance
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';

		if ( ! empty( $link ) && 'file' === $link ) {
			$image_output = wp_get_attachment_link( $id, $size, false, false, false, $attr );
		} elseif ( ! empty( $link ) && 'none' === $link ) {
			$image_output = wp_get_attachment_image( $id, $size, false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $size, true, false, false, $attr );
		}
		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}

		$output .= "<{$itemtag} class='gallery-item'>";

		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";

		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
					<a class='link-overlay' href='#'></a>
					<span class='rhd-caption-wrapper'>" . wptexturize($attachment->post_excerpt) . rhd_ghost_button( 'Take a Look', '#', null, 'center', false, false ) . "</span>
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";

		if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

	$output .= "
		</div>\n";

	return $output;
}
add_filter( 'post_gallery', 'rhd_gallery_shortcode', 10, 3 );