<?php
/**
 * The default template for displaying static page content.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'services-list-item' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="service-thumbnail">
			<?php the_post_thumbnail( 'medium' ); ?>
		</div>
	<?php endif; ?>

	<div class="service-content-area">
		<header class="service-header">
			<h2 class="service-title"><?php the_title(); ?></h2>

			<div class="service-button ghost-button">
				<a href="<?php the_permalink(); ?>" rel="bookmark">Submit Request</a>
			</div>
		</header>

		<div class="service-content">
			<?php echo do_shortcode('[ct id="_ct_textarea_56eb13f634936" property="value"]'); ?>
		</div>
	</div>
</article>