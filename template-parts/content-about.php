<?php
/**
 * The default template for displaying static page content.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2 class="page-title ff-courier"><?php the_title(); ?></h2>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			if ( has_post_thumbnaiL() ) {
				$thumb = get_the_post_thumbnail( get_the_ID(), 'medium' );
				echo rhd_picture_frame( $thumb, 'about-thumb' );
			}
			?>
			
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>

		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
