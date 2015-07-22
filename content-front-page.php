<?php
/**
 * The default template for displaying static page content.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php
	$thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
			<div id="splash">
				<div id="front-page-title">
					<img src="<?php echo RHD_IMG_DIR; ?>/spear-logo.png" alt="Spear Intellectual Property Law">
					<p id="front-page-title-caption">Intellectual Property Law</p>
				</div>

				<?php
					$args = array(
						'theme_location' => 'front-page-mini',
						'container_id' => 'front-page-mini-nav-container',
						'menu_id' => 'front-page-mini-nav',
						'menu_class' => 'site-navigation',
						'container' => 'nav'
					);
					wp_nav_menu( $args );
				?>
			</div>

			<div id="poly-tl" class="poly">
				<canvas width="0" height="0"></canvas>
			</div>
			<div id="poly-tr" class="poly">
				<canvas width="0" height="0"></canvas>
			</div>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>

		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
