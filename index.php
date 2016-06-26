<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
?>

	<?php // if ( $_SESSION['blog_area'] === true ) get_template_part( 'template-parts/metabar' ); ?>

	<section id="primary" class="site-content">
		<div id="content" class="blog-container" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						if ( is_single() ) get_template_part( 'template-parts/content', 'single' );
						else get_template_part( 'template-parts/content' );
					?>
				<?php endwhile; ?>

				<?php
				if ( is_single() ) {
					if ( function_exists( 'rhd_related_posts' ) ) rhd_related_posts( 'rand', 720 );

					rhd_single_pagination();

					if ( comments_open() ) comments_template();
				} else {
					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						rhd_archive_pagination();
				}
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
