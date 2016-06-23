<?php
/**
 * The 404 template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<?php rhd_metabar(); ?>

<section id="primary" class="site-content">
	<div id="content" role="main">
		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'rhd' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'rhd' ); ?></p>

				<?php get_search_form(); ?>
			</div>
		</section>
	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>