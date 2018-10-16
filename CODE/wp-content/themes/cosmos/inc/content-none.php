<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
?>
<div class="content-none-wrapper">
	<div class="page-header">
		<h2 class="title"><?php esc_html_e('We can&rsquo;t find what you&rsquo;re looking for!', 'cosmos'); ?></h2>
	</div>

	<div class="content-none">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( '%1$s <a href="%2$s">%3$s</a>.', esc_html__( 'Ready to publish your first post?', 'cosmos' ), esc_url(admin_url( 'post-new.php' )), esc_html__( 'Get started here' , 'cosmos')); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Please try again with different keywords.', 'cosmos' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'cosmos' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
		<?php do_action('cosmos_show_help_link');?>
	</div>
</div>