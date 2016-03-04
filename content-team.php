<?php
/**
 * The default template for displaying grid-style content.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid-item grid-team' ); ?>>
		<header class="entry-header">
			<div class="grid-thumbnail">
				<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'grid-thumb' ); ?>
			</div>
			<h2 class="entry-title">
				<?php the_title(); ?>
			</h2>
		</header><!-- .entry-header -->
		
		<div class="entry-content">
			<p class="team-position"><?php echo do_shortcode('[ct id="_ct_text_563b8b730c197" property="value"]'); ?></p>
			<p class="team-bio"><?php echo do_shortcode('[ct id="_ct_textarea_563b8b8510fa0" property="value"]'); ?> 
		</div><!-- .entry-content -->
	</article><!-- #post -->
