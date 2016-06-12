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
	Constants
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
	<div class="rhd-picture-frame">
		<div class="framed-picture">
			<?php echo $img_tag; ?>
		</div>
		<img class="frame" src="<?php echo RHD_IMG_DIR; ?>/picture-frame.png" alt="picture frame">
	</div>
	<?php
}


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
		<?php $slugs = array( 'themes', 'techniques', 'genres' ); ?>
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
	$date = get_the_time( get_option( 'date_format' ),  $post->ID );
	$cat_list = get_the_category_list( ', ', '', $post->ID );
	
	// Remove actual post content from display
	$pcontent = '';

	// Append custom field values to the existing content
	// Amend as necessary
	$pcontent = $date . ' | ' . $cat_list;

	return $pcontent;
}
add_filter( 'soliloquy_fc_post_content', 'soliloquy_featured_content_display_custom_fields', 10, 3 );