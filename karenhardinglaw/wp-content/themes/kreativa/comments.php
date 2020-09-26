<?php
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'kreativa' ); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
<div class="commentform-wrap entry-content">
	<h2 id="comments">
		<?php
			printf( _nx( 'One thought on <span>%2$s</span>', '%1$s thoughts on <span>%2$s</span>', get_comments_number(), 'comments title', 'kreativa' ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h2>

	<div class="comment-nav">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php
	wp_list_comments( 'avatar_size=64' ); 
	?>
	</ol>

	<div class="comment-nav">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'kreativa' ); ?></p>
	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<?php
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ) ? " aria-required='true'" : '';
	$html_req  = ( $req ) ? " required='required'" : '';
	$html5     = ( 'html5' === current_theme_supports( 'html5', 'comment-form' ) ) ? 'html5' : 'xhtml';

	$fields = array();

	$fields['author'] = '<div id="comment-input"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_html__( 'Name (required)', 'kreativa' ) . '" size="30"' . $aria_req . $html_req . ' />';
	$fields['email']  = '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . esc_html__( 'Email (required)', 'kreativa' ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' />';
	$fields['url']    = '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_html__( 'Website', 'kreativa' ) . '" size="30" /></div>';

	if ( is_singular('mtheme_proofing') ) {
		$comments_args = array(
				'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
				'comment_field'        => '<div id="comment-textarea"><label class="screen-reader-text" for="comment">' . esc_attr__( 'Message', 'kreativa' ) . '</label><textarea name="comment" id="comment" cols="45" rows="8" required="required" tabindex="0" class="textarea-comment" placeholder="' . esc_html__( 'Message...', 'kreativa' ) . '"></textarea></div>',
				'title_reply'          => esc_html__( 'Leave a message', 'kreativa' ),
				'title_reply_to'       => esc_html__( 'Leave a message', 'kreativa' ),
				'must_log_in'          => '<p class="must-log-in">' .  sprintf( esc_html__( 'You must be %slogged in%s to post a message.', 'kreativa' ), '<a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">', '</a>' ) . '</p>',
				'logged_in_as'         => '<p class="logged-in-as">' . sprintf( esc_html__( 'Logged in as %s. %sLog out &raquo;%s', 'kreativa' ), '<a href="' . admin_url( 'profile.php' ) . '">' . $user_identity . '</a>', '<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . esc_html__( 'Log out of this account', 'kreativa' ) . '">', '</a>' ) . '</p>',
				'comment_notes_before' => '',
				'id_submit'            => 'submit',
				'label_submit'         => esc_html__( 'Post Message', 'kreativa' ),
			);
	} else {
		$comments_args = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<div id="comment-textarea"><label class="screen-reader-text" for="comment">' . esc_attr__( 'Comment', 'kreativa' ) . '</label><textarea name="comment" id="comment" cols="45" rows="8" required="required" tabindex="0" class="textarea-comment" placeholder="' . esc_html__( 'Comment...', 'kreativa' ) . '"></textarea></div>',
			'title_reply'          => esc_html__( 'Leave a comment', 'kreativa' ),
			'title_reply_to'       => esc_html__( 'Leave a comment', 'kreativa' ),
			'must_log_in'          => '<p class="must-log-in">' .  sprintf( esc_html__( 'You must be %slogged in%s to post a comment.', 'kreativa' ), '<a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">', '</a>' ) . '</p>',
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( esc_html__( 'Logged in as %s. %sLog out &raquo;%s', 'kreativa' ), '<a href="' . admin_url( 'profile.php' ) . '">' . $user_identity . '</a>', '<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . esc_html__( 'Log out of this account', 'kreativa' ) . '">', '</a>' ) . '</p>',
			'comment_notes_before' => '',
			'id_submit'            => 'submit',
			'label_submit'         => esc_html__( 'Post Comment', 'kreativa' ),
		);
	}

	?>
	<div class="two-column if-fullwidth-center">
	<?php comment_form( $comments_args ); ?>
	</div>

<?php endif; ?>