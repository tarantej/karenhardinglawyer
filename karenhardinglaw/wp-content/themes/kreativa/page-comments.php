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
	<h4 id="comments"><?php comments_number(esc_html__('No Responses','kreativa'), esc_html__('One Response','kreativa'), esc_html__('% Responses','kreativa') );?></h4>

	<div class="comment-nav">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php 
	$avatar_size=get_option( 'kreativa_avatar_size' );
	if ( empty($avatar_size) ) { $avatar_size=64; }
	wp_list_comments( 'avatar_size=' . $avatar_size ); 
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

<?php
if ( comments_open() ) {
	echo '<div id="commentform-section">';
	$form_args = array( 'title_reply' => esc_html__('Leave a reply','kreativa') );
	comment_form( $form_args );
	echo '</div>';
}
?>