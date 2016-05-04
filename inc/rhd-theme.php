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
			<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( 'front-page-slider', 'slug' ); } ?>
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
					<div class="header-message-photo" style="background-image: url(<?php the_post_thumbnail_url( 'full' ); ?>);">
					</div>
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