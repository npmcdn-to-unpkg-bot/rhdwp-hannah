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


/* ==========================================================================
	Constants and Includes
   ========================================================================== */

define( 'RHD_LOGO_SRC', RHD_UPLOAD_URL . '/2016/05/logo.png' );


/* ==========================================================================
	Functions
   ========================================================================== */

 /**
 * rhd_body_class function.
 *
 * @access public
 * @return void
 */
function rhd_body_class( $body_classes )
{
	// Basic front page & device detection
	$body_classes[] = ( is_front_page() ) ? 'front-page' : '';
	$body_classes[] = ( rhd_is_mobile() ) ?  'mobile' : '';
	$body_classes[] = ( wp_is_mobile() && ! rhd_is_mobile() ) ? 'tablet' : '';
	$body_classes[] = ( ! wp_is_mobile() && ! rhd_is_mobile() ) ? 'desktop' : '';

	session_start();

	if ( is_home() || is_single() || is_archive() || is_search() ) {
		$body_classes[] = 'blog-area';

		$_SESSION['blog_area'] = true;
	} else {
		$_SESSION['blog_area'] = false;
	}

	session_write_close();

	return $body_classes;
}
add_filter( 'body_class', 'rhd_body_class' );


/**
 * rhd_custom_excerpt_length function.
 *
 * @access public
 * @param mixed $length
 * @return void
 */
function rhd_custom_excerpt_length( $length)
{
	return 40;
}
add_filter( 'excerpt_length', 'rhd_custom_excerpt_length' );


/**
 * rhd_custom_excerpt_read_more function.
 *
 * @access public
 * @param mixed $more
 * @return void
 */
function rhd_custom_excerpt_read_more( $more )
{
	global $post;

	return rhd_ghost_button( 'Read More', get_permalink( $post ), null, 'center', true, false );
}
add_filter( 'excerpt_more', 'rhd_custom_excerpt_read_more' );


/**
 * rhd_navbar_search_form function.
 *
 * @access public
 * @return void
 */
function rhd_navbar_search_form()
{
	$output = '
		<form method="get" class="search-form" action="' . esc_url( home_url('/') ) . '">
			<div>
				<input type="text" value="" class="search-field" name="s" />
				<input type="submit" class="search-submit" value="" />
			</div>
			<a class="close-search" href="#">X</a>
		</form>
	';

	echo $output;
}


/**
 * rhd_picture_frame function.
 *
 * @access public
 * @param mixed $img_tag
 * @param mixed $class (default: null)
 * @return void
 */
function rhd_picture_frame( $img_tag, $class = null )
{
	?>
	<div class="rhd-picture-frame <?php echo $class; ?>">
		<div class="framed-picture">
			<?php echo $img_tag; ?>
		</div>
		<img class="frame" src="<?php echo RHD_IMG_DIR; ?>/picture-frame.png" alt="picture frame">
	</div>
	<?php
}


/**
 * rhd_site_intro function.
 *
 * @access public
 * @return void
 */
function rhd_site_intro()
{
	?>
	<div class="site-intro">
		<div class="intro-thumbnail">
			<?php $front = get_option( 'page_on_front' ); ?>
			<?php if ( has_post_thumbnail( $front ) ) : ?>
				<?php rhd_picture_frame( get_the_post_thumbnail( $front, 'large' ), 'intro-image' ); ?>
			<?php endif ;?>
		</div>

		<div class="intro-content-container">
			<div class="intro-hi">Hi!</div>
			<div class="intro-content">
				<?php
				$front_post = get_post( $front );

				echo apply_filters( 'the_content', $front_post->post_content ); ?>
			</div>
		</div>
	</div>
	<?php
}


/**
 * Append the Post's Custom Field values onto the end of the content
 *
 * @param string $pcontent Post Content
 * @param WP_Post $post WordPress Post
 * @param array $data Slider Data
 * @return string $pcontent;
 */
function soliloquy_featured_content_display_custom_fields( $pcontent, $post, $data )
{
	$author_id = $post->post_author;
	$caption = '<span class="rhd-fc-date">' . get_the_time( get_option( 'date_format' ),  $post->ID ) . '</span><br /><a class="rhd-fc-more" href="' . get_the_permalink( $post->ID ) . '" rel="bookmark">Read More</a>';

	// Append custom field values to the existing content (currently overwriting original post content data)
	// Amend as necessary
	$pcontent = $caption;

	return $caption;
}
add_filter( 'soliloquy_fc_post_content', 'soliloquy_featured_content_display_custom_fields', 10, 3 );


/**
 * rhd_entry_details function.
 *
 * @access public
 * @return void
 */
function rhd_entry_details() {
	?>
	<p class="entry-details">By <?php the_author(); ?> <span class="sep">|</span> <?php  the_time( get_option( 'date_format' ) ); ?> <span class="sep">|</span> <?php comments_popup_link( 'Leave a Comment', 'One Comment', '% Comments' ); ?></p>
	<?php
}


/**
 * rhd_archive_grid function.
 *
 * @access public
 * @param mixed $parent_slug
 * @param bool $uncat (default: false)
 * @return void
 */
function rhd_archive_grid( $parent_slug, $uncat = false ) {
	$args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> 8,
	);

	$parent = get_category_by_slug( $parent_slug );
	$parent_id = $parent->term_id;
	$cats = get_terms( 'category', "child_of={$parent_id}" );

	$q = array(); // Array of queries
	$i = 0;
	foreach ( $cats as $cat ) {
		$cat_slug = $cat->slug;

		// Exclude uncategorized (enabled by default)
		if ( $uncat === false && $cat_slug == 'uncategorized' )
			continue;

		$args['category_name'] = $cat_slug;
		$cat = get_category_by_slug( $cat_slug );
		$cat_id = $cat->term_id;
		$cat_name = $cat->name;
		$cat_url = get_category_link( $cat_id );

		$query = new WP_Query( $args );
		?>
		<div class="<?php echo $parent_slug; ?>-grid-container <?php echo $cat-slug; ?>-subcategory-container post-grid-container">
			<h2 class="cat-title"><a href="<?php echo $cat_url; ?>" rel="bookmark"><?php echo $cat_name; ?></a></h2>
			<?php if ( $query->have_posts() ) : ?>
				<div id="<?php echo $cat_slug; ?>-grid" class="post-grid">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'grid' ); ?>
					<?php endwhile; ?>
				</div>
				<div class="cat-more">
					<?php rhd_ghost_button( 'See More &rarr;', $cat_url, '', 'center', false, true ); ?>
				</div>
			<?php endif; ?>
			<?php unset( $q ); ?>
		</div>
		<?php
	}
}


/**
 * rhd_subcat_grid function.
 *
 * @access public
 * @param mixed $parent_slug
 * @param bool $uncat (default: false)
 * @return void
 */
function rhd_subcat_grid ( $parent_slug, $uncat = false ) {
	$parent = get_category_by_slug( $parent_slug );

	$parent_id = $parent->term_id;

	$cats = get_terms( 'category', "child_of={$parent_id}" );
	?>

	<?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
		<ul class="<?php echo $parent_slug; ?>-subcat-grid subcat-grid post-grid">
			<?php foreach ( $cats as $cat ) : ?>
				<?php

				// Exclude uncategorized (enabled by default)
				$cat_id = $cat->term_id;
				$cat_name = $cat->name;
				$cat_url = get_category_link( $cat_id );

				if ( $uncat === false && $cat->slug == 'uncategorized' )
					continue;
				?>

				<li class="subcat-grid-item post-grid-item">
					<a href="<?php echo $cat_url; ?>">
						<?php if ( function_exists( 'z_taxonomy_image' ) ) z_taxonomy_image( $cat->term_id, 'square' ); ?>
						<h2 class="entry-title subcat-title ff-courier"><?php echo $cat_name; ?></h2>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif;
}


function rhd_cat_grid_query( $query ) {
	if ( $query->is_category() && $query->is_main_query() ) {
		$query->set( 'posts_per_page', 18 );
	}
}
add_action( 'pre_get_posts', 'rhd_cat_grid_query' );