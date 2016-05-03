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

		$target = ( $target != '' ) ? "target={$target}" : '';
		$filled = ( $filled != false ) ? 'class="filled"' : '';

        $output = "
                <div class='ghost-button'><a href='{$url}' {$target} {$filled}>{$content}</a></div>
        ";

        return $output;
}
add_shortcode( 'ghost-button', 'rhd_ghost_button_shortcode' );