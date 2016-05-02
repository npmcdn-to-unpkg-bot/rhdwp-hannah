<?php
/**
 * RHD Widgets
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhd
 **/

/**
 * RHD_Store_Locations class.
 *
 * @extends WP_Widget
 */
class RHD_Store_Locations extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_store_locations_widget', // Base ID
			__('Store Locations Widget', 'rhd'), // Name
			array( 'description' => __( 'A list of all Stores, with addresses and phone numbers.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = ( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$title = ( $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : '';

		echo $before_widget;
		?>

		<h3 class="widget-title"><?php echo $title; ?></h3>

		<?php
		$store_args = array(
			'post_type' => 'store',
			'posts_per_page' => -1,
		);
		$stores = new WP_Query( $store_args );
		?>

		<?php if ( $stores->have_posts() ) : ?>

			<ul class="store-locations-list">

			<?php while ( $stores->have_posts() ) : $stores->the_post(); ?>

				<li class="store-location">

					<?php
					$addr = do_shortcode( '[ct id="ct_Address_textarea_e4cb" property="value"]' );
					$phone = do_shortcode( '[ct id="_ct_text_56d70df83ac98" property="value"]' );
					?>

					<h4 class="store-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<div class="store-info">
						<div class="store-address">
							<?php echo wpautop( $addr ); ?>
						</div>
						<a class="store-phone" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
					</div>

				</li>

			<?php endwhile; ?>

			</ul>

		<?php else : ?>
			<li class="store-location no-stores">
				<h3 class="store-name">No Stores Found</h3>
			</li>
		<?php endif;

		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['title'] = esc_attr( $instance['title'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $args['title']; ?>" >
		</p>

<?php
	}
}
function register_rhd_store_locations_widget()
{
    register_widget( 'RHD_Store_Locations' );
}
add_action( 'widgets_init', 'register_rhd_store_locations_widget' );


/**
 * RHD_Auto_Donation_Button class.
 *
 * @extends WP_Widget
 */
class RHD_Auto_Donation_Button extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_auto_donation_button_widget', // Base ID
			__('BUTTON: Auto Donation', 'rhd'), // Name
			array( 'description' => __( 'The "Auto Donation" Button.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['label'] = ( $new_instance['label'] ) ? strip_tags( $new_instance['label'] ) : 'Auto Donation';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$updir = wp_upload_dir();
		$label = ( $instance['label'] ) ? esc_attr( $instance['label'] ) : '';

		echo $before_widget;
		?>

		<div class="big-button big-button-auto-donation">
			<a class="big-button-link" href="<?php echo home_url( '/auto-donation' ); ?>">
				<object class="big-button-svg" id="big-button-car" type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri(); ?>/img/car.svg">
					<img class="big-button-image svg-fallback" src="<?php echo $updir['baseurl']; ?>/2016/03/car.png" alt="Auto Donation">
				</object>
				<p class="big-button-label"><?php echo $label; ?></p>
			</a>
		</div>

		<?php
		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['label'] = esc_attr( $instance['label'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label: ' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo $args['label']; ?>" >
		</p>

<?php
	}
}
function register_rhd_auto_donation_button_widget()
{
    register_widget( 'RHD_Auto_Donation_Button' );
}
add_action( 'widgets_init', 'register_rhd_auto_donation_button_widget' );


/**
 * RHD_Volunteer_Button class.
 *
 * @extends WP_Widget
 */
class RHD_Volunteer_Button extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_volunteer_button_widget', // Base ID
			__('BUTTON: Volunteer', 'rhd'), // Name
			array( 'description' => __( 'The "Volunteer" Button.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['label'] = ( $new_instance['label'] ) ? strip_tags( $new_instance['label'] ) : 'Volunteer';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$updir = wp_upload_dir();
		$label = ( $instance['label'] ) ? esc_attr( $instance['label'] ) : '';

		echo $before_widget;
		?>

		<div class="big-button big-button-volunteer">
			<a class="big-button-link" href="<?php echo home_url( '/volunteer' ); ?>">
				<object class="big-button-svg" id="big-button-bird" type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri(); ?>/img/bird.svg">
					<img class="big-button-image svg-fallback" src="<?php echo $updir['baseurl']; ?>/2016/03/bird.png" alt="Volunteer">
				</object>
				<p class="big-button-label"><?php echo $label; ?></p>
			</a>
		</div>

		<?php
		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['label'] = esc_attr( $instance['label'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label: ' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo $args['label']; ?>" >
		</p>

<?php
	}
}
function register_rhd_volunteer_button_widget()
{
    register_widget( 'RHD_Volunteer_Button' );
}
add_action( 'widgets_init', 'register_rhd_volunteer_button_widget' );


/**
 * RHD_Schedule_Pickup_Button class.
 *
 * @extends WP_Widget
 */
class RHD_Schedule_Pickup_Button extends WP_Widget {
	function __construct() {
		parent::__construct(
				'rhd_schedule_pickup_button_widget', // Base ID
			__('BUTTON: Schedule Pickup', 'rhd'), // Name
			array( 'description' => __( 'The "Schedule Pickup" Button.', 'rhd' ), ) // Args
		);
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['label'] = ( $new_instance['label'] ) ? strip_tags( $new_instance['label'] ) : 'Schedule Pickup';

		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$updir = wp_upload_dir();
		$label = ( $instance['label'] ) ? esc_attr( $instance['label'] ) : '';

		echo $before_widget;
		?>

		<div class="big-button big-button-schedule-pickup">
			<a class="big-button-link" href="<?php echo home_url( '/schedule-pickup' ); ?>">
				<object class="big-button-svg" id="big-button-truck" type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri(); ?>/img/truck.svg">
					<img class="big-button-image svg-fallback" src="<?php echo $updir['baseurl']; ?>/2016/03/bird.png" alt="Schedule Pickup">
				</object>
				<p class="big-button-label"><?php echo $label; ?></p>
			</a>
		</div>

		<?php
		echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['label'] = esc_attr( $instance['label'] );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label: ' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo $args['label']; ?>" >
		</p>

<?php
	}
}
function register_rhd_schedule_pickup_button_widget()
{
    register_widget( 'RHD_Schedule_Pickup_Button' );
}
add_action( 'widgets_init', 'register_rhd_schedule_pickup_button_widget' );