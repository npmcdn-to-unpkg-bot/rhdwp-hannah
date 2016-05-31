<?php
/**
 * The front page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content primary-front-page">
		<div id="content" class="content-front-page" role="main">

			<div class="home-big-img">
				<img alt="Matt Greenberg" src="<?php echo RHD_IMG_DIR; ?>/home-retouched.jpg" alt="Matt Greenberg">
			</div>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>