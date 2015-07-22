<?php
/**
 * The template for displaying single posts
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php
	$thumb_id = get_post_thumbnail_id();
	$thumb_url = array();
	if ( $thumb_id )
		$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
	else
		$thumb_url[0] = content_url() . '/uploads/2015/06/more-spear.jpg';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ); ?>>
	<header class="entry-header" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
		<div class="overlay"></div>
		<h1 id="page-title-big" class="page-title"><?php the_title(); ?></h1>
		<p class="entry-date"><?php the_time( 'n/j/y' ); ?></p>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit Post', 'rhd' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->