<?php
/**
 * RHD Theme Customizations
 *
 * ROUNDHOUSE DESIGNS
 *
 * Add all theme customization functions here.
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/


/**
 * rhd_room_reveal_init function.
 *
 * @access public
 * @return void
 */
function rhd_room_reveal_init() {
	register_post_type( 'room-reveal', array(
		'labels'            => array(
			'name'                => __( 'Room Reveals', 'rhd' ),
			'singular_name'       => __( 'Room Reveals', 'rhd' ),
			'all_items'           => __( 'All Room Reveals', 'rhd' ),
			'new_item'            => __( 'New Room Reveals', 'rhd' ),
			'add_new'             => __( 'Add New', 'rhd' ),
			'add_new_item'        => __( 'Add New Room Reveals', 'rhd' ),
			'edit_item'           => __( 'Edit Room Reveals', 'rhd' ),
			'view_item'           => __( 'View Room Reveals', 'rhd' ),
			'search_items'        => __( 'Search Room Reveals', 'rhd' ),
			'not_found'           => __( 'No Room Reveals found', 'rhd' ),
			'not_found_in_trash'  => __( 'No Room Reveals found in trash', 'rhd' ),
			'parent_item_colon'   => __( 'Parent Room Reveals', 'rhd' ),
			'menu_name'           => __( 'Room Reveals', 'rhd' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor', 'revisions', 'thumbnail' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-multisite',
		'show_in_rest'      => true,
		'rest_base'         => 'room-reveal',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'taxonomies'		=> array( 'post_tag', 'reveal_tag' ),
		'rewrite'			=> array( 'slug' => 'reveals' )
	) );
}
add_action( 'init', 'rhd_room_reveal_init' );


/**
 * rhd_room_reveal_updated_messages function.
 *
 * @access public
 * @param mixed $messages
 * @return void
 */
function rhd_room_reveal_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['room-reveal'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Room Reveals updated. <a target="_blank" href="%s">View Room Reveals</a>', 'rhd'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'rhd'),
		3 => __('Custom field deleted.', 'rhd'),
		4 => __('Room Reveals updated.', 'rhd'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Room Reveals restored to revision from %s', 'rhd'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Room Reveals published. <a href="%s">View Room Reveals</a>', 'rhd'), esc_url( $permalink ) ),
		7 => __('Room Reveals saved.', 'rhd'),
		8 => sprintf( __('Room Reveals submitted. <a target="_blank" href="%s">Preview Room Reveals</a>', 'rhd'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Room Reveals scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Room Reveals</a>', 'rhd'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Room Reveals draft updated. <a target="_blank" href="%s">Preview Room Reveals</a>', 'rhd'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'rhd_room_reveal_updated_messages' );


/**
 * rhd_reveal_tag_init function.
 *
 * @access public
 * @return void
 */
function rhd_reveal_tag_init() {
	register_taxonomy( 'reveal_tag', array( 'post', 'room-reveal' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'            => array(
			'name'                       => __( 'Room Reveal Tags', 'rhd' ),
			'singular_name'              => _x( 'Room Reveal Tag', 'taxonomy general name', 'rhd' ),
			'search_items'               => __( 'Search Room Reveal Tags', 'rhd' ),
			'popular_items'              => __( 'Popular Room Reveal Tags', 'rhd' ),
			'all_items'                  => __( 'All Room Reveal Tags', 'rhd' ),
			'parent_item'                => __( 'Parent Room Reveal Tag', 'rhd' ),
			'parent_item_colon'          => __( 'Parent Room Reveal Tag:', 'rhd' ),
			'edit_item'                  => __( 'Edit Room Reveal Tag', 'rhd' ),
			'update_item'                => __( 'Update Room Reveal Tag', 'rhd' ),
			'add_new_item'               => __( 'New Room Reveal Tag', 'rhd' ),
			'new_item_name'              => __( 'New Room Reveal Tag', 'rhd' ),
			'separate_items_with_commas' => __( 'Room Reveal Tags separated by comma', 'rhd' ),
			'add_or_remove_items'        => __( 'Add or remove Room Reveal Tags', 'rhd' ),
			'choose_from_most_used'      => __( 'Choose from the most used Room Reveal Tags', 'rhd' ),
			'not_found'                  => __( 'No Room Reveal Tags found.', 'rhd' ),
			'menu_name'                  => __( 'Room Reveal Tags', 'rhd' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'reveal_tag',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'rhd_reveal_tag_init' );