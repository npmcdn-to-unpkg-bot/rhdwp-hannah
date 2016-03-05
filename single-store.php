<?php
/**
 * The "Store" CPT single post template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

<?php
$addr = do_shortcode( '[ct id="ct_Address_textarea_e4cb" property="value"]' );
$phone = esc_attr( do_shortcode( '[ct id="_ct_text_56d70df83ac98" property="value"]' ) );
$st_hrs_title = do_shortcode( '[ct id="ct_Store_Hour_textarea_96ea" property="title"]' );
$st_hrs = do_shortcode( '[ct id="ct_Store_Hour_textarea_96ea" property="value"]' );
$don_hrs_title = do_shortcode( '[ct id="ct_Donation_H_textarea_c36d" property="title"]' );
$don_hrs = do_shortcode( '[ct id="ct_Donation_H_textarea_c36d" property="value"]' );
?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="store-header">
				<ul id="single-store-info">
					<li class="single-store-contact">
						<h2 class="store-title store-heading"><?php the_title(); ?></h2>
						<p>
							<?php echo wpautop( $addr ); ?>
							<a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
						</p>
					</li>

					<li class="store-hours">
						<h3 class="store-heading"><?php echo $st_hrs_title; ?></h3>
						<p><?php echo wpautop( $st_hrs ); ?></p>
					</li>

					<li class="donation-hours">
						<h3 class="store-heading"><?php echo $don_hrs_title; ?></h3>
						<p><?php echo wpautop( $don_hrs ); ?></p>
					</li>
				</ul>
			</header><!-- .entry-header -->

			<?php if ( $addr || has_post_thumbnail() ) : ?>
				<div id="single-store-media">
					<div class="single-store-map">
						<?php
						$h = wp_is_mobile() ? '30vh' : '40vh';
						echo do_shortcode( "[pw_map width='100%' height='$h' address='$addr']" );
						?>
					</div>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="single-store-thumbnail">
							<?php the_post_thumbnail( 'large' ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div id="single-store-content">
				<section id="primary" class="site-content">
					<div id="content" role="main">
						<?php
						if ( get_query_var( 'paged' ) )
							$paged = get_query_var( 'paged' );
						else {
							if ( get_query_var( 'page' ) )
							    $paged = get_query_var( 'page' );
							else
								$paged = 1;
						}

						$post_args = array(
							'post_type' => 'post',
							'tax_query' => array(
								'taxonomy' => 'location',
								'field' => 'name',
								'terms' => get_the_title()
							),
							'paged' => $paged
						);

						$post_query = new WP_Query( $post_args );
						?>

						<?php if ( $post_query->have_posts() ) : ?>
							<div id="posts-feed">
								<?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
									<?php get_template_part( 'content' ); ?>
								<?php endwhile; ?>
							</div>
							<?php wp_reset_postdata(); ?>
						<?php endif; ?>
					</div><!-- #content -->
				</section><!-- #primary -->

				<?php get_sidebar( 'store' ); ?>
			</div>
		</article>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>