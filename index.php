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

			<?php if ( is_home() ) : ?>
				<h2 class="page-title"><?php the_title(); ?></h2>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>
				<?php if ( ! is_single() ) : ?>
					<div id="posts-feed">
				<?php endif; ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						if ( is_single() ) {
							get_template_part( 'content', 'single' );
						} else {
							get_template_part( 'content' );
						}
					?>
				<?php endwhile; ?>

				<?php if ( ! is_single() ) : ?>
					</div>
				<?php else : ?>
					<?php if ( is_single() && comments_open() ) comments_template(); ?>
				<?php endif; ?>

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

		<?php
			if ( is_single() ) rhd_single_pagination();
			else rhd_archive_pagination();
		?>

	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
