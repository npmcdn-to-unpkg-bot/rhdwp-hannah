<?php
/**
 * Services Page Template
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content full-width page-services">
		<div id="content" role="main">

			<?php
			if ( have_posts() ) {
				while( have_posts() ) {
					the_post();

					$content = get_the_content();
					$sections = explode( '<hr />', $content );
					$i = 0;
				}
			}
			?>

			<div id="page-services-sections">
				<div class="section section-1">
					<div class="section-left section-image">
						<img src="<?php echo RHD_UPLOAD_URL; ?>/2016/05/color-bathroom-layout-683x1024.jpg" alt="color-bathroom-layout">
					</div>
					<div class="section-right section-content">
						<?php echo apply_filters( 'the_content', $sections[$i] ); ?>
					</div>
				</div>
				<div class="sep"></div>
				<div class="section section-2">
					<div class="section-left section-content">
						<?php echo apply_filters( 'the_content', $sections[++$i] ); ?>
					</div>
					<div class="section-right section-image">
						<!-- BEFORE/AFTER -->
					</div>
				</div>
				<div class="sep"></div>
				<div class="section section-3">
					<div class="section-left section-image">
						<img src="<?php echo RHD_UPLOAD_URL; ?>/2016/05/Millie-bath-After-1-750x1024.jpg" alt="Millie-bath-After-1">
					</div>
					<div class="section-right section-content">
						<?php echo apply_filters( 'the_content', $sections[++$i] ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>