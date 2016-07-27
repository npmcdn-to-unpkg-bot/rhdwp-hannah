<?php
/**
 * The default template for displaying content. Used for both index/archive/search.
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

		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<p class="entry-details">By <?php the_author(); ?> <span class="sep">|</span> <?php the_time( get_option( 'date_format' ) ); ?> <span class="sep">|</span> <?php comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments' ); ?></p>
	</header><!-- .entry-header -->

	<?php if ( is_front_page() || is_archive() ) : ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	<?php else : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php endif; ?>

	<footer class="entry-meta">
		<p><?php edit_post_link( __( 'Edit', 'rhd' ), '<span class="edit-link">', '</span>' ); ?></p>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
