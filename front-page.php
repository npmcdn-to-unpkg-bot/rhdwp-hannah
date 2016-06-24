<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
?>

<section id="primary" class="site-content">
	<div id="content" role="main">

		<div id="features">
			<!-- SLIDER -->
		</div>

		<?php $first = new WP_Query( 'posts_per_page=1' ); ?>
		<?php if ( $first->have_posts() ) : ?>
			<?php while ( $first->have_posts() ) : $first->the_post(); ?>
				<div class="first-post">
					<?php get_template_part( 'template-parts/content', 'front-post' ); ?>
				</div>				
			<?php endwhile; ?>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<?php
			$q = new WP_Query( 'offset=1' );
			$i = 0;
			?>

			<?php while ( $q->have_posts() ) : $q->the_post(); ++$i; ?>
				<?php if ( $i === 1 ) : ?>
					<div class="front-page-posts post-grid">
				<?php endif; ?>

				<?php get_template_part( 'template-parts/content', 'excerpt' ); ?>

				<?php if ( rhd_is_last_post() ) : ?>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>

			<?php
			if ( function_exists( 'wp_pagenavi' ) )
				wp_pagenavi( array( 'query' => $q ) );
			else
				rhd_single_pagination();
			?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No posts to display', 'rhd' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'rhd' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				// Show the default message to everyone else.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'rhd' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'rhd' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?>

	</div><!-- #content -->

</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
