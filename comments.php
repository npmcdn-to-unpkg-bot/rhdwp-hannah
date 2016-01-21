<?php
/**
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
				printf( _n( 'One comment', '%1$s comments', get_comments_number(), 'rhd' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="commentlist">
			<?php wp_list_comments(); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'rhd' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'rhd' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'rhd' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'rhd' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

		<div id="commentform-area">
			<?php
				$required_text = '<span class="required">*</span>';
				$comment_args = array(
					'comment_notes_before' => '<p class="comment-notes">' . __( 'Keep the conversation going! Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
					'comment_notes_after' => '',
					'label_submit' => 'Post',
					'title_reply' => 'Leave a comment!',
					'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment ' . $required_text, 'rhd' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
					'fields' => array(
						'author' =>
						    '<p class="comment-form-author"><label for="author">' . __( 'Name', 'rhd' ) . '</label> ' .
						    ( $req ? $required_text : '' ) .
						    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
						    '" size="30" /></p>',

						'email' =>
							'<p class="comment-form-email"><label for="email">' . __( 'Email', 'rhd' ) . '</label> ' .
							( $req ? $required_text : '' ) .
							'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
							'" size="30" /></p>',

						'url' =>
							'<p class="comment-form-url"><label for="url">' . __( 'Website', 'rhd' ) . '</label>' .
							'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
							'" size="30" /></p>',
					)
				);
				comment_form($comment_args);
			?>
		</div>


</div><!-- #comments .comments-area -->
