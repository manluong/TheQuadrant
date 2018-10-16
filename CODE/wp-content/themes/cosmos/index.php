<?php
/**
 * Index
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
// css to show/hide sidebar.
$cosmos_container_css = cosmos_get_container_css();
get_header();
?>
<div class="archive-page blog-detail-wrapper section blog padding-top-100 padding-bottom-100" >
	<div class="<?php echo esc_attr( $cosmos_container_css['container_css'] );?>">
		<div class="blg-wrapper row">
			<div id="page-content" class="<?php echo esc_attr( $cosmos_container_css['content_css'] ); ?>">
				<?php if ( have_posts() ) : ?>
					<div class="post-wrapper">
						<div class="section-content">
							<!-- The loop -->
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'inc/content' ); ?>
							<?php endwhile; ?>
						</div>
						<div class="clearfix"></div>
						<?php echo cosmos_paging_nav(); ?>
					</div>
					<?php else : ?>
					<div class="section-content-none">
						<?php get_template_part( 'inc/content', 'none' ); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( $cosmos_container_css['has_sidebar'] != 'none' ) { ?>
			<div id='page-sidebar' class="sidebar <?php echo esc_attr( $cosmos_container_css['sidebar_css'] ); ?>">
				<?php cosmos_get_sidebar($cosmos_container_css['sidebar_id']);?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php get_footer();?>