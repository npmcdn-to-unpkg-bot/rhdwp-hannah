<?php
/**
 * The default template for displaying static page content.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php
$class[] = 'full-width-page';
$class[] = has_post_thumbnail() ? 'fixed-bg-page' : 'default-thumb-page';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( implode( " ", $class ) ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<?php echo rhd_full_width_format_cta( get_the_id() ); ?>
		<?php get_template_part( 'template-parts/svg', 'big-notch' ); ?>
	<?php endif; ?>

	<header class="entry-header">
		<h2 class="page-title invisible"><?php the_title(); ?></h2>
	</header><!-- .entry-header -->

	<div class="entry-content entry-content-special">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'rhd' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
</article><!-- #post -->