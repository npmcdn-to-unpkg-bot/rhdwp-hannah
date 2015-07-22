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
	$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ); ?>>
	<header class="entry-header" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
		<div class="overlay"></div>
		<h1 id="page-title-big" class="page-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<p class="entry-date">Published on <?php the_time( 'F j, Y' ); ?></p>
		<?php if (function_exists( 'social_likes' ) ) social_likes(); ?>
		<br />
		<?php edit_post_link( __( 'Edit Post', 'rhd' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->