<?php
/**
 * RHD Featured Categories
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


/**
 * rhd_featured_categories function.
 *
 * @access public
 * @param mixed $loc (default: 'default')
 * @return void
 */
function rhd_featured_categories( $loc = 'default' )
{
	?>
	<ul class="featured-cats featured-cats-<?php echo $loc; ?>">
		<?php $slugs = array( 'occasions', 'techniques', 'styles' ); ?>
		<?php foreach ( $slugs as $slug ) : ?>
			<li class="featured-cat category-<?php echo $slug; ?>">
				<?php $cat = get_category_by_slug( $slug ); ?>

				<a href="<?php echo get_category_link( $cat->term_id ); ?>">
					<?php if ( function_exists( 'z_taxonomy_image' ) ) : ?>
						<?php $src = z_taxonomy_image_url( $cat->term_id, 'square' ); ?>
						<div class="featured-cat-thumbnail">
							<img src="<?php echo $src; ?>" alt="Category: <?php echo $cat->name; ?>">
							<div class="overlay"></div>
							<h4 class="featured-cat-title"><?php echo $cat->name; ?></h4>
						</div>
					<?php else : ?>
						<h2 class="page-title"><?php echo $cat->name; ?></h2>;
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}


/* ==========================================================================
	Widget
   ========================================================================== */

class RHD_Featured_Categories extends WP_Widget {
	function __construct() {
		parent::__construct(
	 		'rhd_featured_categories', // Base ID
			__( 'RHD Featured Categories', 'rhd' ), // Name
			array( 'description' => __( 'Displays pre-configured featured category links in a widget.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$title = ( ! empty( $title ) ) ? apply_filters( 'widget_title', $title ) : '';

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		rhd_featured_categories( 'sidebar' );

		echo $after_widget;
	}

	public function form( $instance ) {
		$args = array();

		$args['title'] = ! empty( $instance['title'] )? esc_attr( $instance['title'] ) : '';
		?>

		<h3><?php _e( 'Widget Options:' ); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>">Widget Title (optional): </label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $args['title']; ?>" >
		</p>

		<?php
	}
}


/**
 * Register RHD_Featured_Categories
 *
 * @access public
 * @return void
 */
function register_rhd_featured_categories_widget()
{
    register_widget( 'RHD_Featured_Categories' );
}
add_action( 'widgets_init', 'register_rhd_featured_categories_widget' );