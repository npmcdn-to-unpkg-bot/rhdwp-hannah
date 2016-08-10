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
		$link = $link ? esc_url( $options["rhd_button_{$i}_link"] ) : false;
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
	$boxes = array();

	$boxes = array(
		1 => array(
			'content'	=>	'<h4 class="donate-cta-heading">Make a one-time gift to the Stanislaus Futures Fund</h4>
							<p>You can choose to give however much you would like to a pool of funds to provide annual scholarships and resources to low-income students and other young people from populations underrepresented in college today.</p>
							<ul class="donate-cta-list">
								<li class="donate-cta-list-item">$1,000 provides one scholarship</li>
								<li class="donate-cta-list-item">$2,500 provides 1-2 scholarships </li>
								<li class="donate-cta-list-item">$5,000 provides 1-2 scholarships plus college access &amp; success services</li>
							</ul>',
			'button'	=>	rhd_ghost_button( 'Donate to Stanislaus Futures', 'https://scf.iphiview.com/scf/Donors/GivingOpportunities/OnlineDonation/tabid/542/dispatch/contribution_id$24871_hash$94f33a13cac03ca887fd2d748b8c60b819bb0b89/Default.aspx', '', 'center' )
		),
		2 => array(
			'content'	=>	'<h4 class="donate-cta-heading">Your Own Named Fund</h4>
							<p>You can establish your own named scholarship fund with a minimum of $10,000 to provide annual scholarships to low-income and underrepresented college students. Your initial contribution will be matched by College Futures Foundation and recipients of your scholarship fund will be tracked throughout their college career.</p>',
			'button'	=>	rhd_ghost_button( 'Create Your Own Named Fund', home_url( '/named-fund' ), '', 'center' )
		)
	);

	$output = '<div class="rhd-donate-cta rhd-cta-boxes">';

	foreach( $boxes as $box => $data ) {
		$output .= "
					<div class=\"donate-cta-box-{$box} donate-cta-box rhd-cta-box\">
						{$data['content']}
						{$data['button']}
					</div>
					";
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
						. rhd_ghost_button( 'Student Assistance', 'http://google.com', '', 'center', true )
					. '</div>
					<div class="front-page-image-cta-box-2 front-page-image-cta-box rhd-cta-box">'						. $image2
						. rhd_ghost_button( 'Help Students', 'http://google.com', '', 'center', true )
					. '</div>
				</div>
			';

	return $output;
}
add_shortcode( 'front-page-image-cta', 'rhd_front_page_image_cta' );