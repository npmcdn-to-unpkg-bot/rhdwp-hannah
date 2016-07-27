<?php
/**
 * The template for displaying single posts
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php $subtitle = get_post_meta( get_the_ID(), 'rhd_post_subtitle', true ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( $subtitle ) : ?>
			<h3 class="entry-subtitle"><?php echo $subtitle; ?></h3>
		<?php endif; ?>

		<h2 class="entry-title"><?php the_title(); ?></h2>
		<p class="entry-details">By <?php the_author(); ?> <span class="sep">&bull;</span> <?php the_time( get_option( 'date_format' ) ); ?></p>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<p>
			<?php the_tags( 'Tags: ', ', ' ); ?><br />
			Filed under: <?php the_category( ' ,' ); ?>
		</p>
		<p><?php edit_post_link( __( 'Edit Post', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
	</footer><!-- .entry-meta -->
</article><!-- #post -->

