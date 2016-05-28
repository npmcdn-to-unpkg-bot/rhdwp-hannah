<?php
/**
 * RHD Custom Post Types
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhdwp-hannah
 **/
 
function rhd_project_init()
{
	register_post_type( 'project', array(
		'labels'            => array(
			'name'                => __( 'Projects', 'rhd' ),
			'singular_name'       => __( 'Projects', 'rhd' ),
			'all_items'           => __( 'Projects', 'rhd' ),
			'new_item'            => __( 'New Projects', 'rhd' ),
			'add_new'             => __( 'Add New', 'rhd' ),
			'add_new_item'        => __( 'Add New Projects', 'rhd' ),
			'edit_item'           => __( 'Edit Projects', 'rhd' ),
			'view_item'           => __( 'View Projects', 'rhd' ),
			'search_items'        => __( 'Search Projects', 'rhd' ),
			'not_found'           => __( 'No Projects found', 'rhd' ),
			'not_found_in_trash'  => __( 'No Projects found in trash', 'rhd' ),
			'parent_item_colon'   => __( 'Parent Projects', 'rhd' ),
			'menu_name'           => __( 'Projects', 'rhd' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'       => true,
		'rewrite'           => array( 'with_front' => true ),
		'query_var'         => true,
		'menu_icon'         => 'dashicons-portfolio',
	) );
}
add_action( 'init', 'rhd_project_init' );

function rhd_project_updated_messages( $messages )
{
	global $post;

	$permalink = get_permalink( $post );

	$messages['project'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Projects updated. <a target="_blank" href="%s">View Projects</a>', 'rhd'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'rhd'),
		3 => __('Custom field deleted.', 'rhd'),
		4 => __('Projects updated.', 'rhd'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Projects restored to revision from %s', 'rhd'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Projects published. <a href="%s">View Projects</a>', 'rhd'), esc_url( $permalink ) ),
		7 => __('Projects saved.', 'rhd'),
		8 => sprintf( __('Projects submitted. <a target="_blank" href="%s">Preview Projects</a>', 'rhd'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Projects scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Projects</a>', 'rhd'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Projects draft updated. <a target="_blank" href="%s">Preview Projects</a>', 'rhd'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'rhd_project_updated_messages' );