<?php
$commenter = wp_get_current_commenter();
$req       = get_option( 'require_name_email' );
$aria_req  = ( $req ? " aria-required='true'" : '' );
$html_req  = ( $req ? " required='required'" : '' );
$format    = 'xhtml';//The comment form format. Default 'xhtml'. Accepts 'xhtml', 'html5'.
$html5     = 'html5' === $format;
$author_field = sprintf(
		'<div class="comment-col comment-col1">
			<input id="author" name="author" type="text" class="comment-field form-input required form-control" value="%2$s" %3$s placeholder="%1$s">
			<div id="author-err-required" class="input-error-msg hide">%4$s</div>
		</div>',
		esc_html__( 'Your Name', 'cosmos' ),//placeholder
		esc_attr( $commenter['comment_author'] ),//value
		$aria_req . $html_req,
		esc_html__( 'Please enter your name.', 'cosmos' )//error message

);
$email_field = sprintf(
		'<div class="comment-col comment-col1">
			<input class="comment-field form-control form-input required"  id="email" name="email" %6$s value="%2$s" size="30" %3$s placeholder="%1$s" />
			<div class="input-error-msg hide" id="email-err-required">%4$s</div>
			<div class="input-error-msg hide" id="email-err-valid">%5$s</div>
		</div>',
		esc_html__( 'Your Email', 'cosmos' ),//placeholder
		esc_attr( $commenter['comment_author_email'] ),//value
		$aria_req . $html_req,
		esc_html__( 'Please enter your email address.', 'cosmos' ),//error message
		esc_html__( 'Please enter a valid email address.', 'cosmos' ),//error message
		( $html5 ? 'type="email"' : 'type="text"' )

);
$class_comment_field = '';
if(!is_user_logged_in()){
	$class_comment_field = 'col-100';
}
$comment_field = sprintf(
		'<div class="%3$s">
			<textarea id="comment" name="comment" required="required" class="comment-field form-control form-textarea form-input" placeholder="%1$s"></textarea>
			<div class="input-error-msg hide" id="comment-err-required">%2$s</div>
		</div>',
		esc_html__( 'Your Message', 'cosmos' ),//placeholder
		esc_html__( 'Please enter comment.', 'cosmos' ),//error message
		esc_attr($class_comment_field)
);

$comments_args = array(
	'cancel_reply_link'   => esc_html__( 'Cancel', 'cosmos' ),
	'comment_notes_before'=> '',
	'format'              => $format,
	'fields'              => array( 'author' => $author_field, 'email' => $email_field),
	'logged_in_as'        => '',
	'class_form'          => 'comment-form',
	'id_form'             => 'commentform',
	'comment_field'       => $comment_field,
	'label_submit'        => esc_html__( 'Submit', 'cosmos' ),
	'title_reply_before'  => '<h3 class="page-title">',
	'title_reply_after'   => '</h3>',
	'title_reply'         => esc_html__( 'Leave your comment', 'cosmos' ),
	'submit_button'       => '<button name="%1$s" id="%2$s" type="submit" class="%3$s btn-submit"><span class="text">%4$s</span><span class="icons fa fa-long-arrow-right"></span></button>',
	'submit_field'        => '%1$s%2$s',
);
ob_start();
comment_form($comments_args);