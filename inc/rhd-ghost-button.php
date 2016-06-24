<?php
/**
 * RHD Shortcodes
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/

/* ==========================================================================
	Functions
   ========================================================================== */

/**
 * rhd_ghost_button function.
 *
 * @access public
 * @param string $content
 * @param mixed $url
 * @param mixed $target (default: '')
 * @param string $align (default: '')
 * @param mixed $filled (default: false)
 * @param bool $echo (default: false)
 * @return void
 */
function rhd_ghost_button( $content, $url, $target = '', $align = '', $filled = false, $echo = false ) {
	$target_att = ( $target ) ? "target={$target}" : '';

	if ( $filled != false ) {
		$filled_class = 'filled';
	} else {
		$filled_class = null;
	}

	$align_class = $align ? "gb-align-$align" : '';

	$output = "<div class='ghost-button-container $align_class'><a href='{$url}' {$target_att} class='ghost-button {$filled_class}'>{$content}</a></div>";

	if ( $echo == true )
		echo $output;
	else
		return $output;
}

/**
 * rhd_ghost_button_shortcode function.
 *
 * @access public
 * @param mixed $atts
 * @param mixed $content (default: null)
 * @return void
 */
function rhd_ghost_button_shortcode( $atts, $content = null ) {
        $a = shortcode_atts( array(
                'url' => '',
                'target' => '',
                'align' => 'center',
                'filled' => false
        ), $atts );

		extract($a);

        return rhd_ghost_button( $content, $url, $target, $filled, false );
}
add_shortcode( 'ghost-button', 'rhd_ghost_button_shortcode' );