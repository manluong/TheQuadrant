<?php
get_header();
$cosmos_container_css = cosmos_get_container_css();
?>
<div class="archive-page blog-detail-wrapper section section-padding padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="row mbxxl blog-detail-wrapper">
			<div id="page-content" class="author-archive <?php echo esc_attr( $cosmos_container_css['content_css'] ); ?>">
				<?php if ( have_posts() ) : 
					$userID = get_query_var('author');
					$display_name = get_the_author_meta( 'display_name', $userID);
					printf('<div class=" author_article page-title ">%s %s</div>',
							esc_html( ucfirst($display_name) ),
							esc_html__( 'Articles', 'cosmos' ));?>
					<div class="post-wrapper">
						<div class="section-content">
							<!-- The loop -->
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'inc/content-search' ); ?>
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
<?php get_footer(); ?>