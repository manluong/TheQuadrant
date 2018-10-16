<?php
/**
 * The template for displaying Search Results pages
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
// css to show/hide sidebar.
$cosmos_container_css = cosmos_get_container_css();

if(get_post_type() == "page") {
	$cosmos_css = '
			#wrapper #content-wrapper {
				padding-top: 80px;
				padding-bottom: 80px;
			}';
	do_action( 'cosmos_add_inline_style', $cosmos_css);
}
get_header();
?>
<div class="archive-page blog-detail-wrapper section blog padding-top-100 padding-bottom-100 ">
	<div class="<?php echo esc_attr( $cosmos_container_css['container_css'] );?>">
		<div class="blog-wrapper row">
			<div id="page-content" class="blog-content <?php echo esc_attr( $cosmos_container_css['content_css'] ); ?>">
				<div class="search-page">
					<?php if ( have_posts() ) : ?>
					 <?php get_search_form();?>
					<div class="news-detail-wrapper">
						<!-- The loop -->
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'inc/content-search' ); ?>
						<?php endwhile; ?>
						<?php echo cosmos_paging_nav(); ?>
					</div>
					<?php else : ?>
						<?php get_template_part( 'inc/content', 'none' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( $cosmos_container_css['has_sidebar'] != 'none' ) :?>
				<div id='page-sidebar' class="sidebar <?php echo esc_attr( $cosmos_container_css['sidebar_css'] ); ?>">
					<?php cosmos_get_sidebar($cosmos_container_css['sidebar_id']);?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer();?>