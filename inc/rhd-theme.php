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
 * rhd_featured_img function.
 * 
 * @access public
 * @param mixed $id
 * @param string $size (default: 'full')
 * @return void
 */
function rhd_featured_img( $id, $size = 'full' )
{
	$thumb_id = get_post_thumbnail_id( $id );
    $thumb_img = wp_get_attachment_image( $thumb_id, $size, false );
    
    echo $thumb_img;
}


/**
 * rhd_get_featured_img function.
 * 
 * @access public
 * @param mixed $id
 * @param string $size (default: 'full')
 * @return void
 */
function rhd_get_featured_img_src( $id, $size = 'full' )
{
	$thumb_id = get_post_thumbnail_id( $id );
    $thumb_img = wp_get_attachment_image_src( $thumb_id, $size, false );
    
    return $thumb_img[0];
}


/**
 * rhd_footer_content function.
 * 
 * @access public
 * @return void
 */
function rhd_footer_content()
{
	get_sidebar( 'footer' );
	?>
    <div class="site-info">
		<p>
			<?php echo '&copy;' . date( 'Y' ); ?> <?php echo bloginfo( 'name' ); ?><br />
			Site by <a href="//roundhouse-designs.com" target="_blank">Roundhouse<img class="rhd-logo-footer" src="//assets.roundhouse-designs.com/images/rhd-white-house.png" alt="Roundhouse Designs">Designs</a>
        </p>
    </div><!-- .site-info -->
    <?php
}