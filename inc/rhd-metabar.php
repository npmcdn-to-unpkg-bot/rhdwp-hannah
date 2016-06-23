<?php
/**
 * RHD Metabar
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


/* ==========================================================================
	Base Functions
   ========================================================================== */

/**
 * rhd_metabar function.
 *
 * @access public
 * @param string $layout (default: 'wide')
 * @param string $fields (default: array( 'cats' => true)
 * @param mixed 'archives' (default: > true)
 * @param mixed 'search' (default: > true ))
 * @return void
 */
function rhd_metabar( $layout = 'wide', $fields = array( 'cats' => true, 'archives' => true, 'search' => true ) ) {
	?>
	<div class="rhd-metabar layout-<?php echo $layout; ?>">
		<div class="rhd-metabar-content">
			<?php if ( $fields['cats'] === true ) : ?>
				<div class="rhd-metabar-item">
					<div class="rhd-dropdown blog-categories">
						<div class="rhd-dropdown-title">
							<span class="dd-title-text">Categories</span>
							<a class="drop" href="">
								<!-- caret -->
							</a>
						</div>
						<ul>
							<?php wp_list_categories( 'title_li=' ); ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( $fields['archives'] === true ) : ?>
				<div class="rhd-metabar-item">
					<div class="rhd-dropdown blog-archives">
						<div class="rhd-dropdown-title">
							<span class="dd-title-text">Archives</span>
							<a class="drop" href="">
								<!-- caret -->
							</a>
						</div>
						<ul>
							<?php wp_get_archives(); ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( $fields['search'] === true ) : ?>
				<div class="rhd-metabar-item">
					<div class="rhd-dropdown blog-search">
						<?php rhd_get_metabar_search_form(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}


/**
 * rhd_metabar_get_search_form function.
 *
 * @access public
 * @return void
 */
function rhd_get_metabar_search_form( $placeholder = 'Search' )
{
	echo '
		<form method="get" class="search-form" action="' . esc_url( home_url('/') ) . '">
			<div>
				<input type="text" value="" class="search-field" placeholder="' . $placeholder . '" name="s" />
				<input type="submit" class="search-submit" value="" />
			</div>
		</form>
		';
}


/* ==========================================================================
	Widget + Shortcode
   ========================================================================== */

class RHD_Metabar extends WP_Widget {
	function __construct() {
		parent::__construct(
	 		'rhd_metabar', // Base ID
			__( 'RHD Metabar', 'rhd' ), // Name
			array( 'description' => __( 'Displays a styled bar with custom dropdowns for categories and archives, plus custom search.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		echo $before_widget;

		$layout = ( ! empty( $instance['layout'] ) ) ? $instance['layout'] : 'wide';

		$fields = array();
		$fields['cats'] = ( ! empty( $instance['cats'] ) ) ? true : false;
		$fields['archives'] = ( ! empty( $instance['archives'] ) ) ? true : false;
		$fields['search'] = ( ! empty( $instance['search'] ) ) ? true : false;

		rhd_metabar( $layout, $fields );

		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args = array();

		$layout = ( ! empty( $instance['layout'] ) ) ? esc_attr( $instance['layout'] ) : '';
		$cats = ( ! empty( $instance['cats'] ) ) ? $instance['cats'] : '';
		$archives = ( ! empty( $instance['archives'] ) ) ? $instance['archives'] : '';
		$search = ( ! empty( $instance['search'] ) ) ? $instance['search'] : '';
?>

		<h3><?php _e( 'Widget Options:' ); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_name( 'layout' ); ?>[wide]">Wide</label>
			<input id="<?php echo $this->get_field_id( 'layout' ); ?>[wide]" name="<?php echo $this->get_field_name( 'layout' ); ?>" type="radio" value="wide" <?php checked( $layout, 'wide' ); ?>>
			<label for="<?php echo $this->get_field_name( 'layout' ); ?>[tall]">Tall (Stacked)</label>
			<input id="<?php echo $this->get_field_id( 'layout' ); ?>[tall]" name="<?php echo $this->get_field_name( 'layout' ); ?>" type="radio" value="tall" <?php checked( $layout, 'tall' ); ?>>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'cats' ); ?>">Categories</label>
			<input id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>" class="checkbox" type="checkbox" value="yes" <?php checked( $cats, 'yes' ); ?>>
			<label for="<?php echo $this->get_field_name( 'archives' ); ?>">Archives</label>
			<input id="<?php echo $this->get_field_id( 'archives' ); ?>" name="<?php echo $this->get_field_name( 'archives' ); ?>" class="checkbox" type="checkbox" value="yes" <?php checked( $archives, 'yes' ); ?>>
			<label for="<?php echo $this->get_field_name( 'search' ); ?>">Search</label>
			<input id="<?php echo $this->get_field_id( 'search' ); ?>" name="<?php echo $this->get_field_name( 'search' ); ?>" class="checkbox" type="checkbox" value="yes" <?php checked( $search, 'yes' ); ?>>
		</p>

<?php
	}
}

/**
 * Register RHD_Metabar widget.
 *
 * @access public
 * @return void
 */
function register_rhd_metabar_widget()
{
    register_widget( 'RHD_Metabar' );
}
add_action( 'widgets_init', 'register_rhd_metabar_widget' );


add_shortcode( 'rhd-metabar', 'rhd_metabar_shortcode' );
function rhd_metabar_shortcode( $atts ) {
	extract( shortcode_atts(
		array(
			'layout'	=> 'wide',
			'cats'		=> 'yes',
			'archives'	=> 'yes',
			'search'	=> 'yes'
		),
		$atts
	));

	$args = array(
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
		'before_widget' => '<div class="widget widget-rhd-metabar">',
		'after_widget'  => '</div>'
	);

	ob_start();
	the_widget( 'RHD_Metabar', $atts, $args );
	$output = ob_get_clean();

	return $output;
}