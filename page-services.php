<?php
/**
 * Services Page Template
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();
global $post;
$page_title = $post->post_title; // Main page title
?>

	<section id="primary" class="site-content full-width page-services">
		<div id="content" role="main">

			<?php
			$args = array(
				'post_type' => 'page',
				'post_parent' => get_the_id(),
				'orderby' => 'menu_order',
				'order' => 'ASC'
			);
			$q = new WP_Query( $args );
			$i = 0;
			?>

			<?php if ( $q->have_posts() ) : ?>

				<div id="services-sections">

				<?php while( $q->have_posts() ) : $q->the_post(); ?>
					<?php
					++$i;
					$evenodd = ( $i % 2 == 0 ) ? 'even' : 'odd';
					$thumb_id = get_post_thumbnail_id();
					$thumb = wp_get_attachment_image_src( $thumb_id, 'full', true );
					?>

					<div class="section section-<?php echo $i; ?>">
						<?php if ( $evenodd == 'odd' ) : ?>
							<div class="section-left section-image">
								<div class="image" style="background-image: url(<?php echo $thumb[0]; ?>);"></div>
							</div>
							<div class="section-right section-content">
								<?php if ( $i == 1 ) : ?>
									<h2 class="page-title"><?php echo $page_title; ?></h2>
								<?php endif; ?>

								<h3 class="services-title"><?php the_title(); ?></h3>
								<?php the_content(); ?>
							</div>
						<?php else : ?>
							<div class="section-left section-content">
								<h3 class="services-title"><?php the_title(); ?></h3>
								<?php the_content(); ?>
							</div>
							<div class="section-right section-image">
								<div class="image" style="background-image: url(<?php echo $thumb[0]; ?>);"></div>
							</div>
						<?php endif; ?>
					</div>
					<?php if ( $i < $q->post_count ) : ?>
						<div class="sep"></div>
					<?php endif; ?>

				<?php endwhile; ?>

				</div>

			<?php endif; ?>
		</div>
	</section>

<?php get_footer(); ?>