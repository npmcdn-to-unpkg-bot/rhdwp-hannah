<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search, as well as home page.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="entry-thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</figure>
	<?php endif; ?>

	<div class="entry-content-container">
		<header class="entry-header">
			<h2 class="entry-title"><?php the_title(); ?></h2>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</div>
</article><!-- #post -->
