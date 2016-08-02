<?php
/**
 * The Category template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();

$cat = $wp_query->get_queried_object();
$children = get_terms( $cat->taxonomy, array( 'parent' => $term->term_id, 'hide_empty' => false ) );
$is_main_cat = ( $cat->category_parent == 0 && $children ) ? true : false;

if ( ! $is_main_cat )
	$parent = get_category( $cat->category_parent );
?>

	<section id="primary" class="site-content full-width">

		<div id="content" role="main">

			<h2 class="page-title archive-title"><?php single_cat_title(); ?></h2>

			<?php if ( have_posts() ) : ?>

				<?php if ( $is_main_cat ) : ?>
					<?php rhd_subcat_grid( $cat->slug ); ?>
				<?php else : ?>
					<div class="post-grid">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/content', 'grid' ); ?>
						<?php endwhile; ?>
					</div>
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

		<?php $exclude = $is_main_cat ? $cat->slug : false; ?>

		<?php
		if ( ! $is_main_cat ) {
			rhd_archive_pagination();
			rhd_ghost_button( "Back to {$parent->cat_name}", get_category_link( $parent->term_id ), '', 'center', false, true );
		}
		?>

		<section id="featured-categories">
			<h2 class="section-title">looking for something else?</h2>
			<?php rhd_featured_categories( 'category-page', $exclude, 'centered' ); ?>
		</section>

	</section><!-- #primary -->

<?php get_footer(); ?>