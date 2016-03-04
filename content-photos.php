<?php
/**
 * The default template for displaying grid-style content.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid-item grid-photos' ); ?>>
		<header class="entry-header">
			<div class="grid-thumbnail">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'grid-thumb' ); ?></a>
				<?php endif; ?>
			</div>
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'rhd' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		</header><!-- .entry-header -->
		
		<div class="entry-content">
			<?php // the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rhd' ) ); ?>
		</div><!-- .entry-content -->
	</article><!-- #post -->
