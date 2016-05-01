<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<div class="content" role="main">
		<section id="front-page-slideshow" class="full-width-slideshow">
			<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '101' ); } ?>
		</section>

		<section id="front-page-content">
			<div id="content" role="main">

				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'front-page' ); ?>
					<?php endwhile; ?>
				<?php endif; ?>

			</div><!-- #content -->
		</section>

		<section id="front-page-big-buttons">
			<div class="big-buttons">
				<?php the_widget( 'RHD_Auto_Donation_Button', 'label=Auto Donation' ); ?>
				<?php the_widget( 'RHD_Volunteer_Button', 'label=Volunteer' ); ?>
				<?php the_widget( 'RHD_Schedule_Pickup_Button', 'label=Schedule Pickup' ); ?>
			</div>
		</section>

		<div id="front-page-news">
			<section id="primary" class="site-content">
				<div id="posts-feed" class="small-thumbnails" role="main">
					<?php
					if ( get_query_var( 'paged' ) )
						$paged = get_query_var( 'paged' );
					else {
						if ( get_query_var( 'page' ) )
						    $paged = get_query_var( 'page' );
						else
							$paged = 1;
					}

					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 3,
						'ignore_sticky_posts' => 1,
						'post__in' => get_option( 'sticky_posts' ),
						'paged' => $paged
					);
					$posts_query = new WP_Query( $args );
					?>

					<?php if ( $posts_query->have_posts() ) : ?>
						<?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
							<?php get_template_part( 'content', 'front-page-post' ); ?>
						<?php endwhile; ?>
					<?php endif; ?>

				</div><!-- #posts-feed -->

				<div class="to-news-page ghost-button">
					<a href="<?php echo home_url( '/news' ); ?>">Read More News</a>
				</div>

			</section><!-- #primary -->

		<?php get_sidebar( 'front-page' ); ?>
		</div>
	</div>

<?php get_footer(); ?>