<?php
/**
 * The "Consolidated Roster" Page template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
			
			<div id="glossary-area">
				<?php
				$alpha = array(
'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u-v','w','x-z'
				);
				?>
				
				<ul id="roster-index">
					<?php foreach ( $alpha as $ltr ) : ?>
						<li class="roster-key roster-key-<?php echo $ltr; ?>">
							<a href="#" data-key="<?php echo $ltr; ?>"><?php echo strtoupper( $ltr ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				
				<div id="roster-table-container"></div>
			</div>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>