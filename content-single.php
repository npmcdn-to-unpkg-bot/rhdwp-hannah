<?php
/**
 * The template for displaying single posts
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<p class="entry-details"><?php  the_time( get_option( 'date_format' ) ); ?><span class="sep"> | </span><span class="entry-cats"><?php the_category( ', ' ); ?></span></p>
	</header>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>
	</div>

	<footer class="entry-meta">
		<p><?php edit_post_link( __( 'Edit Post', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
	</footer>
</article>

