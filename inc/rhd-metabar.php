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
	<div class="blog-metabar layout-<?php echo $layout; ?>">
		<div class="blog-metabar-content">
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
					<div class="blog-archives rhd-dropdown">
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
		</ul>
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
		$instance = array();

		$instance['layout'] = ( $new_instance['layout'] ) ? strip_tags( $new_instance['layout'] ) : '';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		echo $before_widget;

		$fields = array();
		$fields['cats'] = $instance['cats'] ? true : false;
		$fields['archives'] = $instance['archives'] ? true : false;
		$fields['search'] = $instance['search'] ? true : false;

		rhd_metabar( $layout, $fields );

		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args = array();

		$args['layout'] = ! empty( $instance['layout'] )? esc_attr( $instance['layout'] ) : '';
?>

		<h3><?php _e( 'Widget Options:' ); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_name( 'layout' ); ?>[wide]">Wide</label>
			<input id="<?php echo $this->get_field_id( 'layout' ); ?>[wide]" name="<?php echo $this->get_field_name( 'layout' ); ?>" type="radio" value="wide" <?php checked( $args['layout'], 'wide' ); ?>>
			<label for="<?php echo $this->get_field_name( 'layout' ); ?>[tall]">Tall (Stacked)</label>
			<input id="<?php echo $this->get_field_id( 'layout' ); ?>[tall]" name="<?php echo $this->get_field_name( 'layout' ); ?>" type="radio" value="tall" <?php checked( $args['layout'], 'tall' ); ?>>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'cats' ); ?>">Categories</label>
			<input id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>" type="radio" value="yes" <?php checked( $args['cats'], 'yes' ); ?>>
			<label for="<?php echo $this->get_field_name( 'archives' ); ?>">Archives</label>
			<input id="<?php echo $this->get_field_id( 'archives' ); ?>" name="<?php echo $this->get_field_name( 'archives' ); ?>" type="radio" value="yes" <?php checked( $args['archives'], 'yes' ); ?>>
			<label for="<?php echo $this->get_field_name( 'search' ); ?>">Search</label>
			<input id="<?php echo $this->get_field_id( 'search' ); ?>" name="<?php echo $this->get_field_name( 'search' ); ?>" type="radio" value="yes" <?php checked( $args['search'], 'yes' ); ?>>
		</p>

<?php
	}
}