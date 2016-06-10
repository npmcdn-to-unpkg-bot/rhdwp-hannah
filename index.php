 <?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();

if ( get_post_type() == 'post' && is_single() ) wp_redirect( home_url( '/news' ), 301 );
?>
	
	<div id="content" role="main">
		
		<?php if ( is_home() ) : ?>
			<h2 class="page-title">News</h2>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content' ); ?>
					
					<?php if ( ! rhd_is_last_post() ) : ?>
						<hr class="post-sep">
					<?php endif; ?>
					
			<?php endwhile; ?>
			
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
		if ( ! is_single() ) rhd_archive_pagination();
	?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
