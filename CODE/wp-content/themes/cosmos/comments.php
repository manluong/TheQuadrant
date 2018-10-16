<?php
/**
 * The template for displaying comments.
 * 
 * The area of the page that contains both current comments
 * and the comment form.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<?php if ( have_comments() ) : ?>
	<div class="wrapper-comment-list">	
		<h3 class="page-title">
		<?php
			echo get_comments_number( get_the_id());
			echo esc_html__( ' Comments', 'cosmos' );
		?>
		</h3>
		<ul class="comment-list list-unstyled">
		<?php
			$cosmos_commemts_arg = array(
				'per_page'    => get_option( 'page_comments' ) ? get_option( 'comments_per_page' ) : '',
				'callback'    => 'cosmos_display_comments'
			);
			wp_list_comments( $cosmos_commemts_arg );
		?>
		</ul>
		<?php 
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<div class="clearfix"></div>
		<div class="pagination-comment">
			<div class="pagination-wrapper">
				<div class="pagination">
					<?php
						//Create pagination links for the comments on the current post, with single arrow heads for previous/next
						$cosmos_defaults = array(
							'add_fragment' => '#comments',
							'prev_text' => esc_html__( 'Previous', 'cosmos' ), 
							'next_text' => esc_html__( 'Next', 'cosmos' ),
						);
						paginate_comments_links( $cosmos_defaults );
					?>
				</div>
			</div>
		</div>
		<?php endif; // Check for comment navigation. ?>
	</div>

<?php endif; // Check for have_comments(). ?>

<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
?>
<p class="no-comments"><?php esc_html_e( 'Comments are closed', 'cosmos' ); ?>.</p>
<?php endif; ?>

<div class="clearfix"></div>

<?php
//Comment Form
do_action('cosmos_show_frm_comment');
?>