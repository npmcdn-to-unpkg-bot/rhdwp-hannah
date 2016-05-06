<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<section id="primary" class="site-content">
	<div id="content" role="main">
		<?php
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$i = 0;
		?>

		<?php if ( have_posts() ) : ?>

			<div class="blog-container">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					++$i;
					if ( $i == 1 && $paged == 1 )
						get_template_part( 'content', 'full' );
					else
						get_template_part( 'content', 'excerpt' );
					?>
				<?php endwhile; ?>
			</div>

			<?php rhd_archive_pagination(); ?>

		<?php endif; ?>

	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>