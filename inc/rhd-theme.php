<?php
/**
 * RHD Theme Customizations
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhd
 **/

/**
 * rhd_post_meta_links function.
 *
 * @access public
 * @return void
 */
function rhd_post_meta_links()
{
	?>
	<ul class="post-meta">
		<li class="post-meta-item post-cats">
			<span class="post-meta-item-title">Categories</span><br />
			<?php echo get_the_term_list( get_the_ID(), 'category', '', '<br />', null ); ?>
		</li>
		<li class="post-meta-item post-tags">
			<span class="post-meta-item-title">Tags</span><br />
			<?php the_tags( '', '<br />' ); ?>
		</li>
	</ul>
	<?php
}


/**
 * rhd_color_block_shortcode function.
 *
 * @access public
 * @param mixed $atts
 * @param mixed $content (default: null)
 * @return void
 */
function rhd_color_block_shortcode( $atts, $content = null )
{
	if ( $content )
		$content = apply_filters( 'the_content', $content );

	$a = shortcode_atts( array(
		'color' => 'white',
		'id' => ''
	), $atts );

	extract($a);

	$id = $id ? "id='rhd-color-block-{$id}'" : '';

	$output = "<section {$id} class='rhd-color-block rhd-color-block-{$color}'><div class='rhd-color-block-content'>{$content}</div></section>";

	return $output;
}
add_shortcode( 'color-block', 'rhd_color_block_shortcode' );


/**
 * rhd_wpautop_toggle function.
 *
 * Disable wpautop for posts using color-block shortcode.
 *
 * @access public
 * @param mixed $content
 * @return void
 */
function rhd_wpautop_toggle( $content )
{
	if ( has_shortcode( $content, 'color-block' ) )
		remove_filter( 'the_content', 'wpautop' );

	return $content;
}
//add_filter( 'the_content', 'rhd_wpautop_toggle', 0 );


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
		'target' => ''
	), $atts );

	$url = esc_url( $url );

	extract($a);

	if ( $target != '' )
		$target = "target={$target}";
	else
		$target = '';

	$output = "<div class='ghost-button'><a href='{$url}' {$target}>{$content}</a></div>";

	return $output;
}
add_shortcode( 'ghost-button', 'rhd_ghost_button_shortcode' );



/**
 * rhd_full_header function.
 *
 * @access public
 * @return void
 */
function rhd_full_header()
{
	global $post;

	if ( is_front_page() ) {
		?>
		<section id="front-page-slideshow" class="full-width-header">
			<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '130' ); } ?>
		</section>
		<?php
	} elseif ( is_page( 'about' ) ) {
		?>
		<section id="about-page-slideshow" class="full-width-header">
			<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '132' ); } ?>
		</section>
		<?php
	} elseif ( is_page_template( 'template-header-image.php' ) ) {
		?>
		<section id="page-full-header" class="full-width-header">
			<?php the_post_thumbnail( 'full' ); ?>
		</section>
		<?php
	}
}