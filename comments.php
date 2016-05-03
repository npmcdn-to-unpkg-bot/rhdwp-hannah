<?php
/**
 * Kristin Hanggi
 *
 * ROUNDHOUSE DESIGNS
 *
 * Comments template
 *
 * @package WordPress
 * @subpackage rhd
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( 1 === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'rhd' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s thought on &ldquo;%2$s&rdquo;',
							'%1$s thoughts on &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'rhd'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'rhd' ); ?></p>
	<?php endif; ?>

	<div id="commentform-area">
		<?php
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );

			$comment_args = array(
				'comment_notes_before' => '<p class="comment-notes">' . __( 'Keep the conversation going! Your email address will not be published.' ) . '</p>',
				'comment_notes_after' => '',
				'label_submit' => 'Post',
				'title_reply' => 'Leave a comment!',
				'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment <span class="required">*</span>', 'rhd' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
				'fields' => array(
					'author' =>
					    '<p class="comment-form-author"><label for="author">' . __( 'Name', 'rhd' ) . '</label> ' .
					    ( $req ? '<span class="required">*</span>' : '' ) .
					    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					    '" size="30"' . $aria_req . ' /></p>',

					'email' =>
						'<p class="comment-form-email"><label for="email">' . __( 'Email', 'rhd' ) . '</label> ' .
						( $req ? '<span class="required">*</span>' : '' ) .
						'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
						'" size="30"' . $aria_req . ' /></p>'
				)
			);
			comment_form($comment_args);
		?>
	</div>

</div><!-- #comments .comments-area -->
