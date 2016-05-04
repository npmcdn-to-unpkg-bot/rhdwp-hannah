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
 * rhd_front_page_slider function.
 *
 * @access public
 * @return void
 */
function rhd_front_page_slider()
{
	?>
	<section id="front-page-slider">
		<div class="border-inner">
			<!-- slider -->
			<div class="scroll-label">Scroll</div>
		</div>
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
	$has_thumb = ( has_post_thumbnail() ) ? true : false;
	?>
	<section id="header-message-container">
		<div class="border-inner">
			<div class="header-message">
				<?php if ( $has_thumb ) : ?>
					<div class="header-message-photo">
						<?php the_post_thumbnail( 'full' ); ?>
					</div>
				<?php endif; ?>
				<div class="header-message-content">
					<!-- content -->
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
		<div class="border-inner">
			<!-- instagram -->
			<h3 class="section-title">Instagram</h3>
		</div>
	</section>
	<?php
}