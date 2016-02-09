<?php
/**
 * The 404 template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( '404! That page can&rsquo;t be found.', 'rhd' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( "Sorry, the page you're looking for doesn&rsquo;t exist, or has moved. Please try again.", 'rhd' ); ?></p>

					<?php // get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div><!-- #content -->

	</section><!-- #primary -->

<?php get_footer(); ?>