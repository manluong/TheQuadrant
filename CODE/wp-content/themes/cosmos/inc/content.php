<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive.
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
?>
<div class="blog-post content-blog" id="post-<?php the_ID(); ?>">
	<div class="blog-content">
		<div class="blog-detail-content">
			<div class="content">
				<?php do_action( 'cosmos_entry_thumbnail');?>
				<?php
					do_action('cosmos_categories_meta');
					if ( is_single() ) :
						the_title( '<h1 class="title">', '</h1>' );
					else :
						the_title( sprintf( '<a class="title" href="%s" >', esc_url( cosmos_get_link_url() ) ), '</a>' );
					endif;
				?>
				<div class="wrapper-infomation">
					<?php do_action('cosmos_entry_meta');?>
				</div>
				<div class="entry-content description">
					<?php
					the_content( sprintf( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
							get_permalink(),
							esc_html__( 'Read more', 'cosmos' )
					) );
					wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cosmos' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
					?>
				</div>
			</div>
			<div class="clearfix"> </div>
			<!-- categories and tag session -->
			<div class="wrapper-tags">
				<?php do_action('cosmos_tags_meta'); ?>
			</div>
			<div class="wrapper-button">
				<a class="btn link_posts" href="<?php echo get_the_permalink(); ?>" data-type="link"><?php esc_html_e( 'Read more', 'cosmos' ); ?></a>
			</div>
			<!--end -->
		</div>
	</div>
</div>