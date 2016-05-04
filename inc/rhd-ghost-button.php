<?php
/**
 * RHD Shortcodes
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


/**
 * rhd_ghost_button function.
 *
 * @access public
 * @param string $content
 * @param mixed $url
 * @param mixed $target
 * @param mixed $filled (default: false)
 * @param bool $echo (default: false)
 * @return void
 */
function rhd_ghost_button( $content, $url, $target = null, $filled = false, $echo = false )
{
	$target_att = ( $target ) ? "target={$target}" : '';

	if ( $filled != false ) {
		$filled_class = 'filled';
		$auto_color_class = null;
	} else {
		$filled_class = null;
		$auto_color_class = 'auto-color';
	}

	$output = "<div class='ghost-button'><a href='{$url}' {$target_att} class='{$filled_class} {$auto_color_class}'>{$content}</a></div>";

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
function rhd_ghost_button_shortcode( $atts, $content = null )
{
        $a = shortcode_atts( array(
                'url' => '',
                'target' => '',
                'filled' => false
        ), $atts );

		extract($a);

        return rhd_ghost_button( $content, $url, $target, $filled );
}
add_shortcode( 'ghost-button', 'rhd_ghost_button_shortcode' );