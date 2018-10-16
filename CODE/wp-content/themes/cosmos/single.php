<?php
/**
 * The template for displaying all single posts.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
$cosmos_post_type = get_post_type();
$cosmos_params = array( '' );
if(in_array( $cosmos_post_type, $cosmos_params ) && COSMOS_CORE_IS_ACTIVE ){
	$cosmos_post_type = str_replace('cosmos_', '', $cosmos_post_type);
	get_template_part( 'inc/single', $cosmos_post_type );
	return;
}
// css to show/hide sidebar.
$cosmos_container_css = cosmos_get_container_css();

/**
 * Start Template
 */
get_header();
?>
<div class="section blog-detail padding-top padding-bottom">
	<div class="<?php echo esc_attr( $cosmos_container_css['container_css'] ); ?>">
		<div class="blog-detail-wrapper">
			<div class="row">
				<div id="page-content" class="blog-content <?php echo esc_attr( $cosmos_container_css['content_css'] ); ?>">
					<div class="row">
						<div class="col-md-12  blog-detail-wrapper">
							<?php if ( have_posts() ) : ?>
								<div class="section-content">
									<?php /* The loop */ ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php get_template_part( 'inc/single' ); ?>
									<?php endwhile; ?>
									<?php
									cosmos_post_nav();
									if ( is_single() && ( comments_open() || get_comments_number() ) ) :
										echo '<div class="entry-comment comments clearfix blog-comment">';
										comments_template();
										echo '</div>';
									endif;
									?>
								</div>
								<div class="clear-fix" ></div>
							<?php else : ?>
								<?php get_template_part( 'inc/content', 'none' ); ?>
							<?php endif; // have_posts?>
						</div>
					</div>
				</div><!-- #page-content -->
				<?php if ( $cosmos_container_css['has_sidebar'] != 'none' ) :?>
				<div id='page-sidebar' class="sidebar <?php echo esc_attr( $cosmos_container_css['sidebar_css'] )?>">
					<?php cosmos_get_sidebar($cosmos_container_css['sidebar_id']);?>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>