<?php
/**
 * The single Project (CPT) template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<?php
$scsc = do_shortcode( '[ct id="_ct_text_56ec60ca79210" property="value"]' );

$cpattern = '/color=(.*?)[\&|\"]/';

if ( preg_match( $cpattern, $scsc ) ) {
	$scsc = preg_replace( $cpattern, 'color=#003675&', $scsc );
	echo $scsc;
} else { $scsc = preg_replace( '/params=\"/', 'params="color=#003675&', $scsc ); }
?>

<section id="primary" class="site-content <?php echo ( $scsc ) ? 'has-soundcloud' : 'no-soundcloud'; ?>">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>
		<?php endif; ?>

	</div><!-- #content -->
</section><!-- #primary -->

<?php if ( ! empty( $scsc ) ) : ?>
	<div id="secondary" class="soundcloud-sidebar">
		<div class="widget single-project-soundcloud">
			<h3 class="widget-title">Listen</h3>
			<?php if ( has_post_thumbnail() ) : ?>
				<?php $scsc = preg_replace( '/visual=true/', 'visual=false', $scsc ); ?>
				<div class="single-project-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<?php echo do_shortcode( $scsc ); ?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>