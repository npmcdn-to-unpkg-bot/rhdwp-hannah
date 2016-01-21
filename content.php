<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<p class="entry-details">By <?php the_author(); ?> <span class="sep">&bull;</span> <?php  the_time( get_option( 'date_format' ) ); ?></p>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<div class="entry-summary-thumbnail">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'archive' );
					} else {
						$updir = wp_upload_dir();
						?>
						<img src="<?php echo $updir['baseurl']; ?>/2015/10/fallback.jpg" alt="Centsational Girl default">
						<?php
					}
					?>
				</div>

				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>

			</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php if ( ! is_search() ) : ?>
				<?php rhd_social_shares(); ?>
				<?php rhd_entry_meta_box(); ?>

				<?php
				if ( function_exists( 'rhd_related_posts' ) )
					rhd_related_posts();
				?>
			<?php endif; ?>

			<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
