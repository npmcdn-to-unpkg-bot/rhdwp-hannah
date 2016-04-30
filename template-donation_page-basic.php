<?php
/**
 * Template Name Posts: Basic Donation Page Template
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content full-width">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'donation_page' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

	<section id="donation-headline">
		<h3 class="donation-headline-text"><?php rhd_donation_headline(); ?></h3>
	</section>

	<section id="donation-intro">
		<?php rhd_donation_intro_text(); ?>
	</section>

	<div id="donation-form-area">
		<div id="donation-form-container">
			<?php rhd_donation_form(); ?>
		</div>
		<aside id="secondary" class="widget-area" role="complementary">
			<?php rhd_donation_allocations_widget(); ?>
		</aside>
	</div>

<?php get_footer(); ?>