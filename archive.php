<?php
/**
 * The Category template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
?>

<?php if ( $_SESSION['blog_area'] === true ) rhd_metabar( '', array( 'search' => false ) ); ?>

<section id="primary" class="site-content ajax-pagination <?php if ( ! is_archive() ) echo 'full-width'; ?>">

	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php the_archive_title( '<h2 class="archive-title">', '</h2>' ); ?>
			</header>

			<?php rhd_post_grid( null, 'category-grid' ); ?>

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
				</div>

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

	</div>

	<?php rhd_load_more(); ?>

</section>

<?php if ( is_archive() ) get_sidebar(); ?>
<?php get_footer(); ?>