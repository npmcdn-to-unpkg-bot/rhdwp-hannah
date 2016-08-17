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
	preg_match( '/<img class=".*?wp-image-([0-9]*)/', $content, $matches );
	$att_id = $matches[1];

	$img = wp_get_attachment_image( $att_id, 'full' );

	return '<div class="rhd-big-image-container" data-scrollax-parent="true"><div class="rhd-big-image" data-scrollax="properties: { \'translateY\': \'30%\' }">' . $img . '</div></div>';
}
add_shortcode( 'big-image', 'rhd_big_image_image_shortcode' );


/**
 * rhd_cta_buttons function.
 *
 * @access public
 * @param mixed $parent_class (default: null)
 * @return void
 */
function rhd_cta_buttons( $parent_class = null ) {
	$options = get_option( 'rhd_theme_settings' );

	$output = "<div class=\"rhd-cta-buttons {$parent_class}\">";

	$output .= '<div class="cta-buttons">';

	for ( $i = 1; $i <= 3; $i++ ) {
		$label = esc_attr( $options["rhd_button_{$i}_label"] );
		$sub = esc_attr( $options["rhd_button_{$i}_sub"] );
		$link = $options["rhd_button_{$i}_link"] ? esc_url( $options["rhd_button_{$i}_link"] ) : false;
		$text = wpautop( $options["rhd_button_{$i}_text"] );

		$output .= "<div class=\"cta-button-item cta-button-item-{$i}\">";

		if ( $link ) $output .= "<a class=\"cta-button-link\" href=\"{$link}\">";

		$output .= "<div class=\"cta-button\">
						<h4 class=\"cta-label\">{$label}</h4>
							<p class=\"cta-subtitle\">{$sub}</p>
						</div>";
		if ( $link ) $output .= "</a>";

		$output .= "	<div class=\"cta-text-desc\">{$text}</div>
					</div>
					";

		if ( $i < 3 && stripos( $parent_class, 'front-page' ) === false )
			$output .= '<hr class="cta-break" />';
	}

	$output .= "</div></div>";

	return $output;
}


function rhd_cta_buttons_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'class' => null
	), $atts );

	extract( $a );

	return rhd_cta_buttons( $class );
}
add_shortcode( 'cta-buttons', 'rhd_cta_buttons_shortcode' );


/**
 * rhd_donate_cta_shortcode function.
 *
 * @access public
 * @param mixed $atts
 * @return void
 */
function rhd_donate_cta_shortcode( $atts ) {
	$options = get_option( 'rhd_theme_settings' );
	$max_boxes = 2;

	$boxes = array();

	for ( $i = 1; $i <= $max_boxes; $i++ ) {
		$boxes[$i] = array(
			'heading'	=> $options["rhd_donate_cta_area_{$i}_heading"],
			'content'	=> $options["rhd_donate_cta_area_{$i}_content"],
			'button'	=> rhd_ghost_button( esc_attr( $options["rhd_donate_cta_area_{$i}_button_label"] ), esc_url( $options["rhd_donate_cta_area_{$i}_button_link"], '', 'center' ) )
		);
	}

	$output = '<div class="rhd-donate-cta rhd-cta-boxes">';

	foreach( $boxes as $box => $data ) {
		$heading = '<h4 class="donate-cta-heading">' . strip_tags( $data['heading'], '<br>' ) . '</h4>';
		$content = apply_filters( 'the_content', $heading . $data['content'] );
		$button = $data['button'];

		$output .= "<div class=\"donate-cta-box-{$box} donate-cta-box rhd-cta-box\">";
		$output .= $content . $button;
		$output .= '</div>';
	}

	$output .= '</div>';

	return $output;
}
add_shortcode( 'donate-cta', 'rhd_donate_cta_shortcode' );


function rhd_front_page_image_cta( $atts ) {
	$image1 = wp_get_attachment_image( 121, 'large', false, array( 'class' => 'rhd-cta-box-image' ) );
	$image2 = wp_get_attachment_image( 122, 'large', false, array( 'class' => 'rhd-cta-box-image' ) );

	$output = '
		<div class="rhd-front-page-image-cta rhd-cta-boxes">
			<div class="front-page-image-cta-box-1 front-page-image-cta-box rhd-cta-box">'
				. $image1
				. rhd_ghost_button( 'For Students', 'http://google.com', '', 'center', true )
			. '</div>
			<div class="front-page-image-cta-box-2 front-page-image-cta-box rhd-cta-box">'					. $image2
				. rhd_ghost_button( 'For Donors', 'http://google.com', '', 'center', true )
			. '</div>
		</div>
	';

	return $output;
}
add_shortcode( 'front-page-image-cta', 'rhd_front_page_image_cta' );


/**
 * rhd_infographic_shortcode function.
 *
 * @access public
 * @param mixed $atts
 * @param mixed $content (default: null)
 * @return void
 */
function rhd_infographic_shortcode( $atts, $content = null ) {
	if ( ! $content )
		return;

	$a = shortcode_atts( array(
        'image' => 'right'
    ), $atts );

	extract( $a );

	if ( $image == 'right' ) {
		$img_pos = 'right';
		$cap_pos = 'left';
	} else {
		$img_pos = 'left';
		$cap_pos = 'right';
	}

	$content = trim( strip_tags( $content, '<img>' ) );
	$pieces = array();

	preg_match( '/<img(.*?)>/', $content, $matches );
	$img = $matches[0];
	$img = str_replace( 'class="', 'class="rhd-infographic-image ' . $img_pos . ' ', $img);

	$caption = '<figcaption class="rhd-infographic-caption ' . $cap_pos . '">' . strip_tags( $content ) . '</figcaption>';

	// Chicken or the egg...
	if ( stripos( $content, '<img' ) == 0 ) {
		$pieces[0] = $img;
		$pieces[1] = $caption;
	} else {
		$pieces[0] = $caption;
		$pieces[1] = $img;
	}

	$output = '<div class="rhd-infographic"><figure>' . $pieces[0] . $pieces[1] . '</figure></div>';

	return $output;
}
add_shortcode( 'infographic', 'rhd_infographic_shortcode' );