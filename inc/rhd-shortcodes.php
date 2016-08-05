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
 * @param string $align (default: 'center')
 * @param mixed $filled (default: false)
 * @param bool $echo (default: false)
 * @return void
 */
function rhd_ghost_button( $content, $url, $target = '', $align = 'center', $filled = false, $echo = false ) {
	$target_att = ( $target ) ? "target={$target}" : '';

	if ( $filled != false ) {
		$filled_class = 'filled';
	} else {
		$filled_class = null;
	}

	$output = "<div class='ghost-button-container gb-align-{$align}'><a href='{$url}' {$target_att} class='ghost-button {$filled_class}'>{$content}</a></div>";

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

		extract( $a );

        return rhd_ghost_button( $content, $url, $target, $filled, false );
}
add_shortcode( 'ghost-button', 'rhd_ghost_button_shortcode' );


/**
 * rhd_big_image_image_shortcode function.
 *
 * @access public
 * @param mixed $atts
 * @param string $content (default: "")
 * @return void
 */
function rhd_big_image_image_shortcode( $atts, $content = "" ) {
	return '<div class="rhd-big-image-container" data-scrollax-parent="true"><div class="rhd-big-image" data-scrollax="properties: { \'translateY\': \'30%\' }">' . $content . '</div></div>';
}
add_shortcode( 'big-image', 'rhd_big_image_image_shortcode' );


function rhd_cta_buttons( $parent_class = null ) {
	$options = get_option( 'rhd_theme_settings' );

	$output = "<div class=\"rhd-cta-buttons {$parent_class}\">";

	$output .= '<ul class="cta-buttons">';

	for ( $i = 1; $i <=3; $i++ ) {
		$label = esc_attr( $options["rhd_button_{$i}_label"] );
		$sub = esc_attr( $options["rhd_button_{$i}_sub"] );
		$link = esc_url( $options["rhd_button_{$i}_link"] );
		$text = wpautop( $options["rhd_button_{$i}_text"] );

		$output .= "
					<li class=\"cta-button-item cta-button-item-{$i}\">
						<a class=\"cta-button-link\" href=\"{$link}\">
							<div class=\"cta-button\">
								<h4 class=\"cta-label\">{$label}</h4>
								<p class=\"cta-subtitle\">{$sub}</p>
							</div>
						</a>
						<div class=\"cta-text-desc\">" . $text . "</div>
					</li>
					";

		if ( $i < 3 )
			$output .= '<hr class="cta-break" />';
	}

	$output .= "</ul>";
	$output .= "</div>";

	return $output;
}


function rhd_cta_buttons_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'parent_class' => null
	), $atts );

	extract( $a );

	return rhd_cta_buttons( $parent_class );
}
add_shortcode( 'cta-buttons', 'rhd_cta_buttons_shortcode' );