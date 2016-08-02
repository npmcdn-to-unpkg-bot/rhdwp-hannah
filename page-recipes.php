<?php
/**
 * The "Recipes" page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content full-width">

	<?php rhd_metabar( '', array( 'search' => false ) ); ?>

	<div id="content" role="main">
		<?php rhd_archive_grid( 'recipes' ); ?>
	</div>
</section>

<?php get_footer(); ?>