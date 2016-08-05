<?php
/**
 * RHD Login/Admin Branding
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/

/* ==========================================================================
   Roundhouse Admin Branding
   ========================================================================== */

/**
 * rhd_branding_login function.
 *
 * @access public
 * @return void
 */
function rhd_branding_login() {
	return "//roundhouse-designs.com/";
}
add_filter( 'login_headerurl', 'rhd_branding_login' );


/**
 * rhd_login_message function.
 *
 * @access public
 * @return void
 */
function rhd_login_message() {
	echo '<h1 class="rhd-login-site-title">' . get_bloginfo('name') . "</h1>\n";
}
add_action( 'login_message', 'rhd_login_message' );


/**
 * rhd_login function.
 *
 * RHD Login CSS
 *
 * @access public
 * @return void
 */
function rhd_login() {
	wp_enqueue_style( 'rhd_login', get_stylesheet_directory_uri() . '/inc/css/rhd-login.css' );
}
add_action( 'login_head', 'rhd_login' );


/**
 * rhd_admin function.
 *
 * @access public
 * @return void
 */
function rhd_admin() {
	wp_enqueue_style( 'rhd_admin', get_stylesheet_directory_uri() . '/inc/css/rhd-admin.css' );
}
add_action( 'admin_head', 'rhd_admin' );


/**
 * rhd_footer_admin function.
 *
 * @access public
 * @return void
 */
function rhd_footer_admin () {
	return '&copy; ' . date("Y") . ' - Roundhouse <img class="rhd-admin-colophon-logo" src="//assets.roundhouse-designs.com/images/rhd-black-house.png" alt="Roundhouse Designs"> Designs';
}
add_filter( 'admin_footer_text', 'rhd_footer_admin' );