<?php
/**
 * The Front Page main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="page-image-header">
			<?php the_post_thumbnail( 'full' ); ?>
		</div>
	<?php endif; ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

			<?php get_sidebar( 'front-page' ); ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>