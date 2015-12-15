<?php
/**
 * The search results template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header();

$searching_current = ( get_query_var( 'member_class' ) == 'current-members' ) ? true : false;
?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			<header class="page-header">
				<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'rhd' ), get_search_query() ); ?></h2>
			</header><!-- .page-header -->

			<?php if ( have_posts() ) : $post_type = get_post_type(); ?>
				
				<?php if ( $post_type == 'club_member' ) : ?>
					<p style="font-size: 1.1em;">
						<?php if ( $searching_current ) : ?>
							<a href="<?php echo home_url( 'about/current-members' ); ?>">&larr; Back to Current Members</a>
						<?php else : ?>
							<a href="<?php echo home_url( 'history/roster' ); ?>">&larr; Back to Roster</a>
						<?php endif; ?>
					</p>
					<table id='roster-search' class='roster-table'>
						<tr>
							<th class='name'>Name</th>
							<th class='elected'>Year Elected</th>
							
							<?php if ( !$searching_current ) : ?>
								<th class='died'>Year Died</th>
							<?php endif; ?>
							
							<th class='memb_type'>Membership Type</th>
							<th class='notes'>Notes</th>
						</tr>
				
				<?php endif; ?>
				
				<?php while ( have_posts() ) : the_post(); ?>
							
					<?php if ( $post_type == 'club_member' ) : ?>
						<?php
						$ext_link = do_shortcode( '[ct id="_ct_text_5638d53b1e9d4" property="value"]' );
						
						if ( get_the_content() != ' ' ) {
							$link = get_the_permalink();
							$target = "_self";
						} else {
							$link = do_shortcode( '[ct id="_ct_text_5638d53b1e9d4" property="value"]' );
							$target = "_blank";
						}
						
						$terms = get_the_terms( $post->ID, 'membership_type' );
						if ( $terms && ! is_wp_error( $terms ) ) {
							$term_list = array();
							foreach ( $terms as $term ) {
								$term_list[] = $term->name;
							}
							
							$joined_terms = join( ", ", $term_list );
						}
						?>
						<tr>
							<?php $name = ( $link ) ? '<a href="' . $link . '" target="' . $target . '">' . get_the_title() . '</a>' : get_the_title(); ?>
							
							<td><?php echo $name; ?></td>
							<td><?php echo do_shortcode( '[ct id="_ct_text_56382e07e4c3a" property="value"]' ); ?></td>
							
							<?php if ( !$searching_current ) : ?>
								<td><?php echo do_shortcode( '[ct id="_ct_text_56382e13b6858" property="value"]' ); ?></td>
							<?php endif; ?>
							
							<td><?php echo $joined_terms; ?></td>
							<td><?php echo do_shortcode( '[ct id="_ct_text_5638d2dfbf87f" property="value"]' ); ?></td>
						</tr>
					<?php else : ?>
						
						<?php get_template_part( 'content' ); ?>

					<?php endif; ?>
					
				<?php endwhile; ?>

				<?php if ( $post_type == 'club_member' ) : ?>
					</table>
				<?php endif; ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">

				<?php if ( current_user_can( 'edit_posts' ) ) :
					// Show a different message to a logged-in user who can add posts.
				?>
					<header class="entry-header">
						<h2 class="entry-title"><?php _e( 'Sorry, dude. Couldn\'t find anything. Give it another try, we believe in you.', 'rhd' ); ?></h2>
					</header>

					<div class="entry-content">
						<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'rhd' ), admin_url( 'post-new.php' ) ); ?></p>
					</div><!-- .entry-content -->

				<?php else :
					// Show the default message to everyone else.
				?>
					<header class="entry-header">
						<h2 class="entry-title"><?php _e( 'Nothing Found', 'rhd' ); ?></h2>
					</header>

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'rhd' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				<?php endif; // end current_user_can() check ?>

				</article><!-- #post-0 -->

			<?php endif; // end have_posts() check ?>

		</div><!-- #content -->

		<?php rhd_archive_pagination(); ?>

	</section><!-- #primary -->

<?php get_footer(); ?>
